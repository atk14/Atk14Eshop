<?php
/**
 * $filter = new Filter('cards', [
		 'conditions' => ' visible = true,
									 ' visibility_id = :visibility_id',
		 'bind_ar' => [':visibility_id' => $visibility ],
	 ];
	);
	$filter->addJoin('JOIN category_cards cc ON (cc.card_id = cards.id) JOIN category').where('category.id = cc.category_id');
	$filter->addJoin('brands').where('cards.brand_id = brands.id');
	$filter->addSection(new FilterSection('brands', array(
			'join' => 'brands'
	)));
	$filter->addSection(new FilterSection('designers', array(
			'join' => $filter->addJoin('designers').where('cards.designer_id = designers.id')
	)));

  $filter->sections['brands']->possibleChoices();     //[ 1,3,5 ]
	 $filter->sections['brands']->getChoiceLabels();          //[ 1 => 'Mercedes', 2=>  'Audi', 3=> 'Fiat' ]

	$filter->parse($params);
  $filter->sections['brands']->activeChoices();       //[ 1, 5 ]
	$filter->sections['brands']->Count();  //[ 1 => 10, 5 => 5]

	$params = $form->validate();
	$filter->parse($params);
	$finder = new FilterFinder($filter);
	$finder->getRecords() ....
	)
 */

class Filter {
	function __construct($table, $options) {
		$options += [
			'id_field' => 'id',
			'conditions' => [],
			'bind' => [],
			'limit' => 0,
			'offset' => 30,
			'order' => null,
			'prefix' => 'f_',
			'dbmole' => '',
			'model' => null,                //Name of model for created finder
			'materialize_result' => true,   //If the result of the query is needed more than once, materialize it
			'materialize_empty' => true,
			'materialize_fields' => [],
			'fixed_filters' => [],                //add this to result of filter, disable given sections
			'fixed_filter_values' => []           //add this to result of filter, allow to select other values from filter
		];
		$this->options = $options;
		if(!$this->options['dbmole']) {
			global $dbmole;
			$this->options['dbmole'] = $dbmole;
		}

		$this->sections = [];

		//Unmaterialized result for empty sql
		$this->emptySql = (new SqlConditions($table))->where($options['conditions'])->bind($options['bind']);
		$this->emptySql->options['autojoins'] = true;
		$this->emptySql->setSqlOptions(array_intersect_key($this->options, ['order', 'limit','offset']));

		//Materialized result for unfiltered sql
		$this->preparedSql = $this->emptySql;

		//Unmaterialized result for filtered sql
		$this->parsedSql = null;
		$this->parsedSqlCount = [];
		$this->emptySqlCount = null;
		//Materialized result for filtered sql
		$this->materializedSql = null;

		$this->params = null;
		$this->filtered = false;
		$this->table = $this->emptySql->getTableName();
	}

	function __clone() {
		if( $this->preparedSql !== $this->emptySql) {
			$this->emptySql = clone $this->emptySql;
			$this->preparedSql = clone $this->preparedSql;
		} else {
			$this->preparedSql = $this->emptySql = clone $this->emptySql;
		}
		$this->sections=array_map(function($v) {return clone $v;}, $this->sections);
	}

	function getModel() {
		return $this->options['model']?:(string) (new String4($this->table))->camelize()->singularize();
	}

	/**
	 * Return sql object of query without filtering (all objects)
	 */
	function emptySql() {
		if($this->options['materialize_empty']) {
			$this->materialize();
		}
		return $this->preparedSql;
	}

	/**
	 * Return sql object of query with applied filters
	 */
	function parsedSql() {
		return $this->parsedSql;
	}

	function getMaterializedFields($secondary = false) {
		$fields = [ $this->getIdField() ];
		foreach($this->sections as $s) {
			$fields = array_merge( $fields, $s->getMainTableFields());
		}

		if($of = $this->options['materialize_fields']) {
			if(is_array($of)) {
				$fields = array_merge($fields, $of);
			} else {
				$fields[] = $of;
			}
		}
		$fields = array_flip(array_flip($fields));
		$main = $this->emptySql->getTableName();
		$fields = array_map(function($v) use($main, $secondary) {
				if(preg_match("/([a-zA-Z_][a-zA-Z0-9_]*)\\.(.+)/",$v, $matches)) {
					$t = $matches[1];
					if($t == $main) { return $v; };
					$f = $matches[2];
					return $secondary ? "$main.{$t}_{$f}" : "$v as {$t}_{$f}";
				} else {
					return $v;
				}
		}, $fields);
		return $fields;
	}

	/**
	 *  Precompute available products (nonfiltered)
	 **/
	function materialize($options = []) {
		if($this->preparedSql !== $this->emptySql) {
			return;
		}

		$fields = $this->getMaterializedFields();

		$this->preparedSql = $this->emptySql->materialize($this->getDbmole(),$fields, [
			'copy_joins' => $this->sectionsJoinNames(),
			'fields' => $fields,
			'table_name_pattern' => 'materialized_filter',
		]);
	}

	/**
	 * Get all join that is used for filtering
	 */
	function sectionsJoinNames() {
		$out = [];
		foreach($this->sections as $section) {
			$out = array_merge($out, $section->getJoinNames());
		}
		return $out;
	}

	/**
	 * Add condition for filter. E.g.
	 * $filter = new Filter('cards');
	 * $filter->addCondition('visible AND NOT deleted');
	 */
	function addCondition($condition) {
		return $this->preparedSql->where($condition);
	}

	/**
	 * Add bind variable for filter conditions.
	 * $filter = new Filter('cards');
	 * $filter->addCondition('visible = :visible');
	 * $filter->addBind(':visible', true);
	 */
	function addBind($name, $value = null) {
		return $this->preparedSql->bind($name, $value);
	}

	/**
	 * Set SqlOptions - limit, order etc...
	 * see SqlResult->setSqlOptions()
	 * $filter->setSqlOptions(['limit' => 10, 'offset' => 0, 'order' => 'name DESC']);
	 */
	function setSqlOptions($options) {
		$this->emptySql->setSqlOptions($options);
		if( $this->emptySql !== $this->preparedSql) {
			$this->preparedSql->setSqlOptions($options);
		}
		if($this->parsedSql) {
			$this->parsedSql->setSqlOptions($options);
		}
	}

	/**
	 * Add join to filter (for conditions on filtered items)
	 * e.g. limit filtered products for those whose brand is visible
	 * $join = $filter->addJoin('brands')->where('product.brand_id = brands.id AND brands.visible = true')
	 * WARNING: Added joins MUST BE ACTIVATED, if they should be applied regardless of
	 * filter choices, otherwise will be applied only when some filter secion condition them!!!
	 * $join->setActive();
	 */
	function addJoin($table, $where = null) {
		return $this->preparedSql->join($table, $where);
	}

	/**
	 * Parse params and generate $this->parsedSql object with propper conditions
	 * $params = $form->validate();
	 * $filter->parse($params);
	 * $finder = new FilterFinder($filter);
	 * $finder->getRecords() ....
   */
	function parse($params) {
		if($params === null) {
			$params = [];
		}
		$this->parsedSql = $this->preparedSql->copy();
		$this->parsedSqlCount = [];
		$this->params = null;
		$this->materializedSql = null;
		$this->filtered = false;

		foreach($this->sections as $section) {
			$this->filtered = $section->parse($params, $this->parsedSql) || $this->filtered;
		}
	}

	/**
	 * Some options have been selected in filter?
	 */
	function isFiltered() {
		return $this->filtered;
	}

	/**
	 * The filter has already parsed params?
	 */
	function isParsed() {
		return (bool) $this->parsedSql;
	}

	/**
	 * Returns number of items that match the filter (regardless the limit and offset)
	 * echo "Found {$filter->getRecordCounts()} records";
	 */
	function getRecordsCount($field = null) {
		if(!$field) {
			$field = $this->getIdField();
		}

		if(!key_exists($field, $this->parsedSqlCount)) {
			$result = $this->result();
			$this->parsedSqlCount[$field] = (int) $this->getDbMole()->selectSingleValue(
					$result->select("COUNT(DISTINCT $field)",false),
					$result->bind
			);
		}
		return $this->parsedSqlCount[$field];
	}

	/** Returns number of items without any filter **/
	function getAllRecordsCount() {
		if($this->emptySqlCount === null) {
			$result = $this->emptySqlResult();
			$this->emptySqlCount = (int) $this->getDbMole()->selectSingleValue(
					$result->select("COUNT(DISTINCT {$this->getIdField()})",false),
					$result->bind
			);
		}
		return $this->emptySqlCount;
	}

	/** Returns number of items without any filter **/
	function unfilteredRecordExists() {
		$result = $this->emptySqlResult();
		return $result->select("EXIST {$this->getIdField()})",false);
	}



	/**
	 * Returns query and bind params for obtainings ids of filtered products
	 * Possible multiple occurences of id must be a bit specially handled by
	 * generating SQL
	 * list($sql, $bind) = $filter->resultSql();
	 * Cards::FindAll([
			'conditions' => "id IN ({$result->select('id')})",
			'bind_ar' => $result->bind]);
	 */
	function resultSql($sqlOptions = []) {
		$sql = $this->result($sqlOptions);
		return $query = $sql->distinctOnSelect( $this->getIdField() );
	}

	/**
	 * Returns SQLResult object - sql query for obtaining ids of items that fits the filter
	 * $result = $filter->result(['limit' => 10]);
	 * Cards::FindAll([
			'conditions' => "id IN ({$result->select('id')})",
			'bind_ar' => $result->bind]);
	 */
	function result($sqlOptions = []) {
		if(!$this->isParsed() || !$this->filtered) {
			return $this->emptySqlResult($sqlOptions);
		}

		if(key_exists('materialize', $sqlOptions)) {
			$materialize = $sqlOptions['materialize'];
			if($materialize === 'if_requested') {
				$materialize = $materialize && $this->options['materialize_result'];
			}
			unset($sqlOptions['materialize']);
		} else {
			$materialize = null;
		}
		if( $materialize === null ) { $materialize=
			$this->options['materialize_result'] &&
			$this->options['materialize_result'] !== 'if_requested' &&
			!$sqlOptions;
		}

		if( !$materialize ) {
			return $this->parsedSqlResult($sqlOptions);
		}


		if( !$this->materializedSql ) {
			$fields = $this->getMaterializedFields( $this->emptySql !== $this->preparedSql);
			$this->materializedSql = $this->parsedSql->materialize(
				$this->getDbmole(),
				$fields, [
					'table_name_pattern' => 'materialized_filter',
			]);
		}
		return $this->materializedSql->result();
	}

	//INTERNAL METHODS

	/**
	 * Returns SqlResult object for query WITHOUT filter conditions
	 **/
	function emptySqlResult($options = []) {
		return $this->emptySql()->result($options);
	}

	/**
	 * Returns SqlResult object for query WITH filter conditions
	 */
	function parsedSqlResult($options = []) {
		return $this->parsedSql->result($options);
	}

	/**
	 * Returns full sql expression for id field of filtered table
	 * $filter->getIdField();
	 * >> cards.id
   */
	function getIdField() {
		return "{$this->table}.{$this->options['id_field']}";
	}

	/** Returns database access object **/
	function getDbMole() {
		return $this->options['dbmole'];
	}

	/**
	 * Add filter section. Don no use directly, create filter
   * section with propper filter argument
   */
	function add($section) {
		$name = $section->getName();
		if(key_exists($name, $this->sections)) {
			throw new Exception("Section already exists");
		}
		$this->sections[$section->getName()] = $section;
		if(key_exists($name, $this->options['fixed_filters'])) {
			$section->setFixed( $this->options['fixed_filters'][$name] );
		}
		if(key_exists($name, $this->options['fixed_filter_values'])) {
			$section->setFixedValues( $this->options['fixed_filter_values'][$name] );
		}
	}

	function getParams() {
		if($this->params === null) {
			$f = function($v) { return $v->getParams();};
			$params = array_map($f, $this->sections);
			$this->params = call_user_func_array('array_merge', $params);
		}
		return $this->params;
	}

	/***
	 * Return array of active filter choices
	 * [
			['params' => <remaining params to generate "remove 1st choice URL">, 'label' => 'label of first active choice]
			['params' => <remaining params to generate "remove 2nd choice URL">, 'label' => 'label of second active choice]
		]
	 *@param array params added to all resulting items
	 **/
	function getActiveFilters($commonParams=[]) {
		$out = [];
		$params = $this->getParams();
		if($params) {
			foreach($this->sections as $section) {
				$sparams = $section->getActiveFilters($params);
				if($commonParams) {
					$sparams = array_map(function($v) use($commonParams) {
						$v['params'] = $v['params'] + $commonParams;
						return $v;
					}, $sparams);
				}
				$out = array_merge($out, $sparams);
			}
		}
		return $out;
	}

	function sortedSections() {
		$sections = $this->sections;
		usort($sections, function($a, $b) {
			if($a->getRank() == $b->getRank()) {
				$a = $a->getName();
				$b = $b->getName();
			} else {
				$a = $a->getRank();
				$b = $b->getRank();
			}
			if($a == $b) {
				return 0;
			}
			return $a > $b ? 1 : -1;
		});
		return $sections;
	}
}
