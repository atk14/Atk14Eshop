<?php
/***
 * Structured SQL Query. Each SqlConditions describes one table.
 *
 * $sql = new SqlConditions('cards');
 * $sql->where('visible = 1);
 * $sql->where('visible = :visible', ':visible', true);
 * $sql->where('visible = :visible')->bind(':visible', true);
 * $sql->where('visible = :visible')->bind([':visible', true]);
 * $sql->join('products')->where('products.card_id = cards.id');

 * $sql = new SqlConditions('cards');
 * $sql->namedWhere('visible', 'visible = :visible')->bind(':visible', true);
 * $join = $sql->join('products p')->where('p.card_id = cards.id');
 * var_dump($sql->result()->select('id'));
 * "SELECT id FROM cards JOIN products p ON (p.card_id = cards.id) WHERE visible = :visible", [':visible'] => true
 * var_dump($sql->result(['disable_where' => 'visible')->select('id'));
 * "SELECT id FROM cards JOIN products p ON (p.card_id = cards.id)", [':visible'] => true
 * var_dump($sql->result(['not_where' => 'visible')->select('id'));
 * "SELECT id FROM cards JOIN products p ON (p.card_id = cards.id) WHERE NOT (visible = :visible)", [':visible'] => true
 *
 * $join->setActive('auto')
 * var_dump($sql->result()->select('id'));
 * #no named join in $join, so it is not included
 * "SELECT id FROM cards WHERE NOT (visible = :visible)", [':visible'] => true
 * var_dump($sql->result([active_join => 'p'])->select('id'));
 * #no named join in $join, so it is not included
 * "SELECT id FROM cards JOIN products p ON (p.card_id = cards.id) WHERE NOT (visible = :visible)", [':visible'] => true
 * $join->namedWhere(deleted, 'not p.deleted');
 * var_dump($sql->result()->select('id'));
 * #no named join in $join, so it is not included
 * "SELECT id FROM cards JOIN products p ON (p.card_id = cards.id AND not p.deleted) WHERE NOT (visible = :visible)", [':visible'] => true
 *
 * $sql->setSqlOptions(['limit' => 5]);
 * var_dump($sql->result()->select('id'));
 * "SELECT id FROM cards JOIN products p ON (p.card_id = cards.id AND not p.deleted) WHERE NOT (visible = :visible) LIMIT 5", [':visible'] => true
 **/

class SqlConditions {
	function __construct($table, $where = [], $bind_ar = [], $options = []) {
		$this->table = $table;
		$this->name = $this->parseTableName();
		$this->where = is_array($where)?$where:[$where];
		$this->bind = $bind_ar;
		$this->join = [];
		$this->pattern = null;
		$this->sqlOptions = [];
		$this->active = true;
		$this->options = $options + array(
			'autojoins' => false, //added joins are active only if they have a named where condition
													 //or they are manually activated
			'join' => 'JOIN'
		);
	}

	/***
		$cond->where('visible = True');
		$cond->where('visible = :visible', [ ':visible' => true ]);
		$cond->where('visible = :visible', ':visible', true);

		add named where condition (see SqlConditions::namedWhere)
		$cond->where(['not_null_brand' => 'brand_id IS NOT NULL']);
	 */
	function where($where, $bind_ar = null, $bind_value=null) {
		if(is_array($where)) {
			$this->where = array_merge($this->where, $where);
		} elseif($where) {
			$this->where[] = $where;
		}
		if($this->pattern) {
			$this->pattern->where($where);
		}
		$this->bind($bind_ar, $bind_value);
		return $this;
	}

	/**
	 * Add where condition, that is named and can be (when query result is obtained)
	 * - disabled: $sql->result(['disable_where' => 'name'])
	 * - negated: $sql->result(['not_where' => 'name'])
	 *
	 * $sql->namedWhere('not_null_brand', 'brand_id IS NOT NULL');
	 *
	 * If $this->active === 'auto', any named where "switch on" the join, while
	 * anonymous do not (they are considered as rules how to join or restrict the table)
	 */
	 function namedWhere($name, $where) {
		if($where === null) {
			unset($this->where[$name]);
		} else {
			return $this->where([$name => $where]);
		}
	}

	/** Add bind variable(s)
	 *
	 * $sql->bind(':visible', true);
	 * $sql->bind([':visible' => true, ...]);
	 */
	function bind($name, $value = null) {
		if(is_array($name)) {
			$this->bind+=$name;
		} elseif($name) {
			$this->bind[$name] = $value;
		}
		if($this->pattern) {
			$this->pattern->bind($name, $value);
		}
		return $this;
	}

	/**
	 * Creates SQLResult object.
	 * See class documentation for examples
	 */

	function result($options = []) {
		$options = self::PrepareOptions($options);
		if(!$this->isActive($options)) { return null; };

		$where = array_diff_key($this->where, $options['disable_where']);
		foreach(array_intersect_key($where,$options['not_where']) as $k => $v) {
				$where[$k] = "NOT ($v)";
		}
		if($options['add_where']) {
			$where = array_merge($where, $options['add_where']);
			$options['add_where'] = [];
		}

		if($where) {
			$where = "(" . implode(') AND (', $where) . ")";
		} else {
			$where = "";
		}
		$sqlOptions = $options['sql_options'] + $this->sqlOptions;
		$result = new SqlResult($this->table, $where, $this->bind, $sqlOptions);

		foreach($this->join as $join) {
			$join->joinTo($result, $options);
		}
		return $result;
	}

	/**
	 * Sets default SQL options used by result(). See SqlResult::$DefaultSqlOptions
	 * $sql->setSqlOptions([
		 'order' => 'cards.id DESC',
		 'limit' => 5,
		 'offset' => 10,
		 'group' => 'cards.id',
		 'having' => 'blablabla'
		 ]);
	 */
	function setSqlOptions($options) {
		$this->sqlOptions=$options+$this->sqlOptions;
	}

	/* Name of the join - now same as alias of the table */
	function getName() {
		return $this->name;
	}

	/* Alias of table */
	function getTableName() {
		return $this->name;
	}

	/** How to join to parent table  */
	function getJoinBy($options=[]) {
		if(isset($options['override_join'][$this->name])) {
			return $options['override_join'][$this->name];
		}
		return $this->options['join'];
	}

	/**
	 * $table->setJoinBy("LEFT JOIN");
	 **/
	function joinBy($join) {
		$this->options['join'] = $join;
		return $this;
	}

	/** Set whether the table will be joined to parent table
		* $sql->setActive(true); // always join
		* $sql->setActive(false); // join, only if explicitly requested (['active_join' => [ $sql->getName() ]])
		* $sql->setActive('auto'); // acts as false if no named where condition on table is specified,
																	and no child join is active, true otherwise
    */
	function setActive($active = true) {
		$this->active = $active;
		if($this->pattern) {
			$this->pattern->setActive($active);
		}
	}

	/**
	 * Determine, whether join is active.
	 * $sql->setActive(false);
	 * $sql->isActive(); // false
	 * $sql->isActive(['active_join' => $sql->getName]); // true
	 * $sql->namedWhere('visible', 'visible');
	 * $sql->isActive(); //true
	 */
	function isActive($options=[]) {
		$options = self::PrepareOptions($options);
		if(key_exists($this->name, $options['active_join'])) { return true; };
		if($this->active === 'auto') {
			$out = array_diff_key($this->where, $options['disable_where']);
			foreach($out as $k => $v) { //activate join only if named where condition present
				if(is_string($k)) { return true; }
			}
			foreach($this->join as $j) {
				if($j->isActive($options)) {
					return true;
				}
			}
			return false;
		}
		return $this->active;
	}

	/**
		$cond->join("cards")->where('cards.id = product.card_id');
		$cond->join("cards c",'c.id = product.card_id');
		$cond->join("(product_cards JOIN cards ON (product.id = product_cards.product_id)) pcc");
	*/
	function join($table, $where=null) {
		$join = new SqlConditions($table);
		$name = $join->getName();
		if(key_exists($name, $this->join)) {
			throw new Exception("Join '$name' exists");
		}
		$this->join[$name] = $join;
		if($where) {
			$join->where($where);
		}
		if($this->options['autojoins']) {
			$join->setActive('auto');
		}
		if($this->pattern) {
			$pat = $this->pattern->join($table, $where);
			$join->pattern = $pat;
		}
		return $join;
	}

	function getJoin($name) {
		if(!key_exists($name, $this->join)) {
			return null;
		}
		return $this->join[$name];
	}

	function copy() {
		return clone $this;
	}

	/***
	 * Join this table to a SqlResult (see SqlCoditions::result())
	 * $sql = new SQLConditions('cards');
	 * $sql_child = new SQLConditions('brands')->where('cards.brand_id = brands.id');
	 * $result = $sql_child->joinTo($sql->result());
	 * $result->select('cards.id');
	 * >> SELECT cards.id FROM cards JOIN brands ON (cards.brand_id = brands.id)
	 */
	function joinTo($parent_result, $options = []) {
		$result = $this->result($options);
		if($result) {
			$parent_result->join($result, $this->getJoinBy($options));
		}
		return $parent_result;
	}

	// INTERNAL METHODS
	/** Extract alias of table from table expression. From join it extract last table alias
	 * cards => cards
	 * cards c => c
	 * (category_cards cc join cards c ON (...)) => c
	 */
	function parseTableName() {
		# "(a JOIN b ON (....))" => "(a JOIN b"
		if(substr($this->table, -1) == ')') {
			$table = substr($this->table, 0, strrpos(strtolower($this->table), ' on ', -1));
		} else {
			$table = $this->table;
		}

		#"blablabla JOIN b" => "b"
		#"jakakolivtabulka alias" => "alias"
		$pos = strrpos($table, ' ');
		if($pos !== false) {
			$table = substr($table, $pos+1);
		}
		return $table;
	}

	function __clone() {
		$this->cloneJoinsFrom($this);
	}

	function cloneJoinsFrom($from, $options=[]) {
		static $defaults = [
			'only_names' => false,
			'inherit' => false,
			'anonymize_where' => false
		];
		$store = $defaults;
		$options += $defaults;
		$defaults = $options;

		$joins = $from->join;
		if($options['only_names'] !== false) {
			$joins = array_intersect_key($joins, array_flip($options['only_names']));
		}
		$this->join = array_map(function($o) use($options) {
				$join = clone $o;
				if($options['inherit']) {
					$join->pattern = $o;
				}
				if($options['anonymize_where']) {
					$join->where = array_values($join->where);
				}
				return $join;
			},
			$joins);
		$defaults = $store;
	}

	/**
	 * Parse options for result() method - add missing keys,
	 * make arrays from can be array or single value fields and
	 * flip some arrays (for efficient searching)
	 */
	static function PrepareOptions($options = []) {
		if(!key_exists('_prepared', $options)) {
			$options+= [
				'_prepared' => true,
				'active_join' => [],
				'disable_where' => [],
				'not_where' => [],
				'join' => false,
				'add_where' => [],
				'sql_options' => [],
				'override_join' => []
			];

			#make arrays or flip
			foreach(['not_where', 'disable_where', 'active_join'] as $i) {
				if(is_array($options[$i])) {
					$options[$i] = array_flip( $options[$i] );
				} else {
					$options[$i] = [ $options[$i] => true ];
				}
			}

			#just make array
			if(!is_array($options['add_where'])) {
				$options['add_where'] = [ $options['add_where'] ];
			}
		}
		return $options;
	}


	function materialize($dbmole, $fields,$options) {
		static $tableCounter = 1;
		$options+= [
			'table_name' => null,
			'table_name_pattern' => 'materialized_query',
			'copy_joins' => false,
			'sql_options' => [
				'limit' => null,
				'offset' => null,
				'order' => null
			],
			'inherit' => true
		];
		if( is_array($fields) ) {
			$fields = implode(',', $fields);
		}
		$tableName = $options['table_name']?:$options['table_name_pattern'].($tableCounter++);
		$sqlOptions = $options['sql_options'] + $this->sqlOptions;
		$result = $this->result();
		$sql = $result->select($fields, $sqlOptions);
		$dbmole->doQuery("CREATE TEMPORARY TABLE $tableName AS $sql", $result->bind);
		$out = new SqlConditions("$tableName {$this->getTableName()}", [], [], $this->options);
		if($options['inherit']) {
			$out->pattern = $this;
		}
		if($options['copy_joins'] !== false) {
			$out->cloneJoinsFrom($this, [
				'inherit' => $options['inherit'],
				'only_names' =>  $options['copy_joins'],
				'anonymize_where' => true
			]);
			/*foreach($out->join as $join) {
				$join->setActive(false);
			}*/
		}
		$out->bind = $this->bind;
		return $out;
	}
}
