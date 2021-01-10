<?php
/**
 * The base class of every model`s test case class.
 *
 * Notice that TcBase is descendant of TcAtk14Model
 * so there are a couple of special member variables in advance.
 */
class TcBase extends TcAtk14Model{

	function setUp(){
		$this->dbmole->begin();
		$this->setUpFixtures();
	}

	function tearDown(){
		$this->dbmole->rollback();
	}

	function callForData($data, $function, $arguments = []) {
		end($data);
		$name = key($data);
		$vals = array_pop($data);
		if($data) {
			foreach($vals as $v) {
				$this->callForData($data, $function, $arguments + [ $name => $v ]);
			}
		}	else {
			foreach($vals as $v) {
				$function($arguments + [$name => $v]);
			}
		}
	}
}
