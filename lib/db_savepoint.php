<?php
/** Class, that allow nice recovery after database error. Usage:

$savepoint = new DbSavepoint();
$savepoint->run( function() {...});

$savepoint = new DbSavepoint();
if($error = $savepoint->runError( function() {...})) { echo 'ERROR: $error'; };

$savepoint = new DbSavepoint();
if($error = $savepoint->runError( function() {...})) { echo 'ERROR: $error'; };
**/


class DbSavepoint {

	static $Counter = 1;

	static function GetDbMole($mole = null) {
		if(!$mole) {
			global $dbmole;
		} else {
			$dbmole = $mole;
		}
		return $dbmole;
	}

	function __construct($mole = null, $options = array()) {
		if(is_array($mole)) {
			$options = $mole;
			$mole = null;
		}
		$this->dbmole = self::GetDbMole($mole);
		$this->options = $options + array(
			'autostart' => true,
			'hide_error_output' => true,
			'verbose' => false
			);
		$this->names = array();
	}

	protected function autostart() {
		if($this->options['autostart']) {
			if($this->options['verbose']) {
				echo "AUTO";
			}
			$this->begin();
		}
	}

	protected function autoend() {
		if($this->options['autostart']) {
			if($this->options['verbose']) {
				echo "AUTO";
			}
			$this->commit();
		}
	}

	protected function autorollback() {
		if($this->options['autostart']) {
			if($this->options['verbose']) {
				echo "AUTO";
			}
			$this->rollback();
		}
	}

	/*** Vytvori novy savepoint ***/
	function begin() {
		$this->names[] = $id = self::$Counter++;
		$this->dbmole->doQuery("savepoint DbSavepoint__$id");
		if($this->options['verbose']) {
			echo "STARTED SAVEPOINT $id\n";
		}
	}

	/*** Odstrani (a potvrdi) savepoint - samozrejme, je jeste treba potvrdit celou transakci a pripadne nerollbacknout 'nadrazene' savepointy ***/
	function commit() {
		$id = array_pop($this->names);
		$this->dbmole->doQuery("release DbSavepoint__$id");
		if($this->options['verbose']) {
			echo "COMMITED SAVEPOINT $id\n";
		}
	}

	/*** Rollbackne savepoint a popr. ho i odstrani ***/
	function rollback($release = true) {
		$id = $release?array_pop($this->names):end($this->names);
		$query = "rollback to DbSavepoint__$id";

		if($release) {
			$query .= "; release DbSavepoint__$id";
			$msg = " AND DESTROYED";
		} else {
			$msg = '';
		}
		$this->dbmole->_ErrorRaised = false;
		$this->dbmole->doQuery($query);

		if($this->options['verbose']) {
			echo "ROLLBACKED TO$msg SAVEPOINT $id\n";
		}
	}




	/** Spusti danou funkci. Pri chybe databaze vyhodi DbSavepointException a je-li $this->options['autostart'],
			tak vrati DB do stavu pred spustenim funkce.
			$dbsavepoint->runArgs(function() { Product::CreateNewRecord(array('name' => 'nejlepsi produkt', 'price' => 1)) });
	***/
	function run($f) {
		$this->autostart();
		$dbmole = $this->dbmole;
		$old = $dbmole->getErrorHandler();
		$dbmole->setErrorHandler(function($mole) {
			throw new DbSavepointException($mole->getErrorMessage());
		});

		try {
			if($this->options['hide_error_output']) {
				$out = @$f();
			} else {
				$out = $f();
			}
		} catch(Exception $e) {
			$this->autorollback();
			throw $e;
		} finally {
			$dbmole->setErrorHandler($old);
		}
		$this->autoend();
		return $out;
	}

	/** Spusti danou funkci s danymi argumenty. Pri chybe databaze vyhodi DbSavepointException a je-li
			$this->options['autostart'], tak vrati DB do stavu pred spustenim funkce.
			$dbsavepoint->runArgs(array('Product' => 'CreateNewRecord'), array('name' => 'nejlepsi produkt', 'price' => 1));
	***/
	function runArgs($f) {
		$args = array_slice(func_get_args(), 1);
		return $this->run(function() use($f, $args) {return call_user_func_array($f, $args); });
	}

	/** Spusti danou funkci. Vrati pripadnou chybovou hlasku databaze nebo null. Je-li $this->options['autostart'],
			tak pri chybe vrati DB do stavu pred spustenim funkce.
			$error = $dbsavepoint->runArgs(function() { Product::CreateNewRecord(array('name' => 'nejlepsi produkt', 'price' => 1)) });
	***/
	function runError($f) {
		try {
			$this->run($f);
			return null;
		} catch (DbSavepointException $e) {
			return $e->getMessage();
		}
	}

	/** Spusti danou funkci s danymi argumenty. Vrati pripadnou chybovou hlasku databaze nebo null.
			Je-li $this->options['autostart'], tak pri chybe vrati DB do stavu pred spustenim funkce.
			$error = $dbsavepoint->runArgs(array('Product' => 'CreateNewRecord'), array('name' => 'nejlepsi produkt', 'price' => 1));
	***/
	function runErrorArgs($f) {
		$args = array_slice(func_get_args(), 1);
		return $this->runError(function() use($f, $args) {return call_user_func_array($f, $args); });
	}

	/** Spusti dane sql a vrati null nebo chybovou hlasku, pokud sql neprojde.
			Je-li $this->options['autostart'], tak pri chybe vrati DB do stavu pred spustenim funkce.
			$dbsavepoint->runSql('INSERT INTO moznaneexistujicitabulka VALUES (:values)', array(':values' => 1));
	***/
	function runSql($sql, $bind_ar = array()) {
		$dbmole = $this->dbmole;
		return $this->runError(function() use($dbmole, $sql, $bind_ar) { $dbmole->doQuery($sql, $bind_ar); } );
	}

	static function Savepoint($fce, $mole = null) {
		$i = new self($mole);
		return $i->run($fce);
	}

	static function SavepointError($fce, $mole = null) {
		$i = new self($mole);
		return $i->runError($fce);
	}
}
/** This exception is throwed when db error is encountered.**/
class DbSavepointException extends Exception {};
