<?php
/**
 * Result of SqlConditions. Usage:
 * $result = new SqlResult('cards', 'visible = :visible', [':visible' => true ],[ 'limit' =>10 ]);
 * $this->dbmole->selectRows($result->select('id'), $result->bind);
 * $this->dbmole->selectRows($result->select('id'), $result->bind);
 */
class SqlResult {
	function __construct($table, $where, $bind = [], $sqlOptions = []) {
		$this->table = $table;
		$this->join = '';
		$this->where = $where;
		$this->bind = $bind;
		$this->sqlOptions = $this->prepareSqlOptions($sqlOptions + ['add_options' => false]);
	}

	/** Default options for **/
	static $DefaultSqlOptions =  [
			'order' => null,
			'group' => null,
			'having' => null,
			'limit' => null,
			'offset' => null,
			'add_options' => true //if false, DO NOT add $this->sqlOptions
		];

	function exists($options=[]) {
		return 'SELECT EXISTS(' . $this->select($options) . ')';
	}

	function count($options=[]) {
		return $this->select("COUNT(*)", $options);
	}

	/***
	 * Return query selecting given field
	 * $result = new SqlResult('cards', 'visible');
	 * $result->select('id');
	 * >> SELECT id FROM cards WHERE visible
   */
	function select($field = '*', $options = []) {
		$where = $this->where;
		if($where) {
			$where = "WHERE $where";
		}
		return "SELECT {$field} \n FROM {$this->table} {$this->join} \n $where {$this->tail($options)}";
	}

	/***
	 * Select only rows distinct on given field, but sorted according to the
	 * another fields. It is a bit tricky - it requires distinct-on subquery
	 * with proper fields. Resulting query has sheme
	 * SELECT f1,f2 FROM (<DISTINCTED QUERY>) _q(f1,f2,f3,f4,f5) ORDER BY 3,4,5
	 * $ids = call_user_func_array([$dbmole,'selectIntoArray'], $result->distinctOnSelect());
	 */
	function distinctOnSelect($field = 'id', $sqlOptions = []) {
		$sqlOptions = $this->prepareSqlOptions($sqlOptions);
		if(!$sqlOptions['order']) {
			$query = $this->select("distinct on ($field) $field");
		} else {
			$order = $sqlOptions['order'];
			if(is_array($order)) {
				$order = array_values($order);
			} else {
				$order = $this->_splitFields($order);
			}
			#odstranime ASC DESC a zapamatujeme
			$order_fields = array_map(function ($v) { return preg_replace('/([^\s])\s+(ASC|DESC)(\s+NULLS\s+(FIRST|LAST))?\s*$/i','\1', $v); },  $order);
			$desc = array_map(function ($order, $field) {return substr($order,strlen($field));}, $order, $order_fields);

			$ffield = $field . ',' . implode(',', $order_fields);
			$sqlOptions['order'] = $ffield;
			//Tricky part: because of the ordering result must be
			//out of the distincted query to be applied, the result should be
			// SELECT f1,f2 FROM (<DISTINCTED QUERY>) _q(f1,f2,f3,f4,f5) ORDER BY 3,4,5
			$flen=$this->countFields($field, $sqlOptions, 'fields_count');
			$alias = range(1,count($order)+$flen);
			$alias = array_map(function ($v) {return "f$v";}, $alias);
			$fields = implode(',', array_slice($alias, 0,$flen));

			$order = array_slice($alias, $flen);
			$order = array_map(function($o, $d) {return $o . $d;}, $order, $desc);
			$order = implode(',', $order);
			$alias = implode(',', $alias);

			$query = $this->select("distinct on ($field) $ffield",
				['limit' => false, 'offset' => false, 'order' => false] + $sqlOptions);
			$query = "SELECT $fields FROM ($query) _q($alias) ORDER BY $order, $fields " . $this->limitOffset($sqlOptions);
		}
		return array($query, $this->bind);
	}

	static function _splitFields($fields) {
		$out = [];
		$start = 0;
		$len = strlen($fields);
		$state = null;
		$parenthesis = 0;

		for($i=0;$i<strlen($fields);$i++) {
			switch($state) {
				case "'": if($fields[$i]=="'") $state=''; break;
				case '"': if($fields[$i]=='"') $state=''; break;
				default: switch($fields[$i]) {
				case '"':	$state = '"'; break;
				case "'":	$state = "'"; break;
				case '(': $parenthesis +=1;break;
				case ')': $parenthesis -=1;break;
				case ',': if(!$parenthesis) {
						$out[] = substr($fields,$start,$i-$start);
						$start = $i+1;
					};
					break;
				}
				break;
			}
		}

		$out[] = substr($fields, $start);
		return $out;
	}

	/***
	 * Try to guess number of fields in SQL fragment
	 * Not reliable, so one can give the propper number of fields
	 * in options of given name (see distinctOnSelect)
	 */
	function countFields($sql, $opts=[], $name=null) {
		if(isset($opts[$name]) && $opts[$name]) {
			return $opts[$name];
		}
		do {
			$old = $sql;
			$sql=preg_replace("/[(][^()]*[)]/",'', $sql);
		} while($sql != $old);
		$sql = preg_replace('/[^,]/','', $sql);
		return strlen($sql) + 1;
	}

	/***
	 * Return tail part of SQL query according to the options
	 * $result->tail(['group' => 'brand_id', 'limit' => 5]);
	 * > GROUP BY brand_id LIMIT 5
   **/
	function tail($sqlOptions = []) {
		$sqlOptions = $this->prepareSqlOptions($sqlOptions);
		$tail='';
		if($sqlOptions['group']) { $tail=' GROUP BY '.$sqlOptions['group']; }
		if($sqlOptions['having']) { $tail.=' HAVING '.$sqlOptions['having']; }
		if($sqlOptions['order']) {
			$order = $sqlOptions['order'];
			if(is_array($order)) {
				$order = implode(',', $order);
			}
			$tail.="\n ORDER BY $order";
		}
		if($sqlOptions['limit']) { $tail.=' LIMIT '.$sqlOptions['limit']; }
		if($sqlOptions['offset']) { $tail.=' OFFSET '.$sqlOptions['offset']; }
		return $tail;
	}

	/**
	 * Return limit offset part of sql query
	 * $result->tail(['group' => 'brand_id', 'limit' => 5]);
	 * > LIMIT 5
	 */
	function limitOffset($sqlOptions = []) {
		$sqlOptions = ['group' => false, 'having' => false, 'order'=>false] +
									$sqlOptions;
		return $this->tail($sqlOptions);
	}

	/** Set SQL options
	 *  $result->SqlOptions(['limit' => 10]);
   *  echo $result->select('id');
	 *  >> SELECT id FROM cards LIMIT 10;
   *  echo $result->select('id', ['add_options' => false]);
	 *  >> SELECT id FROM cards;
	 **/
	function sqlOptions($options) {
		$this->sqlOptions = $options + $this->sqlOptions;
	}

	/***
	 * Join another Sql result to given result
	 * $result = new SqlResult('cards');
	 * $child = new SqlResult('product', 'cards.id = product.id');
	 * $result->join($child, 'LEFT JOIN');
	 * echo $result->select('id, product.id');
	 * > SELECT id, product.id FROM cards LEFT JOIN products ON ( cards.id = product.id )
	 */
	function join($child, $by='JOIN') {
		if($child->join) {
			$table = "({$child->table} {$child->join})";
		} else {
			$table = $child->table;
		}
		$this->join .= "\n $by $table ON ({$child->where})";
		$this->bind+=$child->bind;
		return $this;
	}

	/***
	 * Add condition
	 * $result = new SqlResult('cards');
	 * $result->addWhere('brand_id = 1');
	 * echo $result->select('id');
	 * > SELECT id FROM cards WHERE brand_id = 1
	 */
	function andWhere($where) {
		if(!$where) { return; }
		if($this->where) {
			$this->where = "({$this->where}) AND ($where)";
		} else {
			$this->where = $where;
		}
	}

	//INTERNAL METHODS

	/**
	 * Complete Sql options either by self::$DefaultValues (if add_options = false) or
	 * $this->sqlOptions
	 */
	function prepareSqlOptions($options = []) {
		if($options === false) {
			$options = self::$DefaultSqlOptions;
		} elseif(key_exists('add_options', $options) && !$options['add_options']) {
			$options += self::$DefaultSqlOptions;
			unset($options['add_options']);
		} else {
			$options +=$this->sqlOptions;
		}
		return $options;
	}
}
