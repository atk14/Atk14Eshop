<?php
use \SqlBuilder\SqlTable;
use \SqlBuilder\MaterializedSqlTable;
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

class Filter implements IteratorAggregate {
	var $hasNoRecords = false;
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
			'model' => null,                 //Name of model for created finder
			'materialize' => true,           //Materialize dataset of all possible records
			'materialize_result' => true,    //Materialize dataset of all filtered records
			'materialized_fields' => [],
			'default_landing_page' => false,      //Default value for landing_page option of sections.
		];
		if(isset($options['fixed_filter_values'])) {
			throw new Exception("Removed options fixed_filter_values and fixed_filters. Use ['section'][\$name]['fixed'|'fixed_values'])");
		};
		if(isset($options['fixed_filters'])) {
			throw new Exception("Removed options fixed_filter_values and fixed_filters. Use ['section'][\$name]['fixed'|'fixed_values'])");
		};
		if(isset($options['materialize_fields'])) {
			throw new Exception("Filter: materialize_fields renamed to materialized_fields");
		};


		$this->options = $options;
		if(!$this->options['dbmole']) {
			global $dbmole;
			$this->options['dbmole'] = $dbmole;
		}

		$this->sections = [];
		$this->visibleSections = null;

		//Unmaterialized result for empty sql
		if($table instanceof SqlTable) {
			$this->unfilteredSql = $table;
		} else {
			$this->unfilteredSql = (new SqlTable($table));
	  }
		$this->unfilteredSql->where($options['conditions'])->bind($options['bind']);
		$this->unfilteredSql->options['autojoins'] = true;
		$this->unfilteredSql->setSqlOptions(array_intersect_key($this->options, ['order', 'limit','offset']));

		$this->unfilteredSql = new MaterializedSqlTable($this->unfilteredSql, $this->getDbmole(), function() {
			return [
				'fields' => $this->getMaterializedFields(),
				'copy_joins' => $this->sectionsJoinNames(),
				'table_name_pattern' => 'materialized_filter'
			];
			}, ['materialize' => $options['materialize']]
		);

		$this->clearPrecomputed();
	}

	function getIterator() {
		if($this->visibleSections===null) {
			$this->visibleSections=$this->visibleSections();
		}
		return new ArrayIterator($this->visibleSections);
	}

	function clearPrecomputed() {
		$this->unfilteredSqlCount = null;
		$this->filteredSql = null;
		$this->resultSql = null;
		$this->filteredSqlCount = [];

		$this->params = null;
		$this->filtered = false;
		$this->unfilteredSql->table->pattern = null;
		$this->table = $this->unfilteredSql->getTableName();
	}

	function __clone() {
		$this->unfilteredSql = clone $this->unfilteredSql;
		if($this->filteredSql) {
			$this->filteredSql = clone $this->filteredSql;
		}
		if($this->resultSql) {
			$this->resultSql = clone $this->resultSql;
			$this->unfilteredSql->pattern = $this->resultSql;
		}
		$this->sections=array_map(function($v) {return clone $v;}, $this->sections);
	}

	function getModel() {
		return $this->options['model']?:(string) (new String4($this->table))->camelize()->singularize();
	}

	/**
	 * Return sql object of query without filtering (all objects)
	 */
	function unfilteredSql() {
		return $this->unfilteredSql;
	}

	/**
	 * Return sql object of query with applied filters
	 */
	function filteredSql() {
		return $this->filteredSql;
	}

	function getMaterializedFields($secondary = false) {
		$fields = [ $this->getIdField() ];
		foreach($this->sections as $s) {
			$fields = array_merge( $fields, $s->getMainTableFields());
		}

		if($of = $this->options['materialized_fields']) {
			if(is_array($of)) {
				$fields = array_merge($fields, $of);
			} else {
				$fields[] = $of;
			}
		}
		$main = $this->unfilteredSql->getTableName();
		$fields = array_map(function($v) use($main, $secondary) {
				if(preg_match("/([a-zA-Z_][a-zA-Z0-9_]*)\\.(.+)/",$v, $matches)) {
					$t = $matches[1];
					$f = $matches[2];
					if($t == $main) {
						return $secondary === 'empty' ? $f : $v;
					};
					if($secondary === 'empty') {
						return "{$t}_{$f}";
					} else if($secondary) {
						return "$main.{$t}_{$f}";
					} else {
						return  "$v as {$t}_{$f}";
					}
				} else {
					return $v;
				}
		}, $fields);
		$fields = array_flip(array_flip($fields));
		return $fields;
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
		return $this->unfilteredSql->where($condition);
	}

	/**
	 * Add bind variable for filter conditions.
	 * $filter = new Filter('cards');
	 * $filter->addCondition('visible = :visible');
	 * $filter->addBind(':visible', true);
	 */
	function addBind($name, $value = null) {
		return $this->unfilteredSql->bind($name, $value);
	}

	/**
	 * Set SqlOptions - limit, order etc...
	 * see SqlResult->setSqlOptions()
	 * $filter->setSqlOptions(['limit' => 10, 'offset' => 0, 'order' => 'name DESC']);
	 */
	function setSqlOptions($options) {
		$this->unfilteredSql->setSqlOptions($options);
		if($this->filteredSql) {
			$this->filteredSql->setSqlOptions($options);
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
		return $this->unfilteredSql->join($table, $where);
	}

	/**
	 * Parse params and generate $this->filteredSql object with propper conditions
	 * $params = $form->validate();
	 * $filter->parse($params);
	 * $finder = new FilterFinder($filter);
	 * $finder->getRecords() ....
   */
	function parse($params) {
		if($params === null) {
			$params = [];
		}
		$this->filteredSql = $this->unfilteredSql->copy();
		$this->resultSql = new MaterializedSqlTable(
			$this->filteredSql,
			$this->getDbMole(),
			function() { return [
				'fields' => $this->getMaterializedFields( $this->unfilteredSql->isMaterialized()),
				'table_name_pattern' => 'materialized_filter'
			]; },
			[
				'materialize' => $this->options['materialize_result'],
			]
		);
		$this->unfilteredSql->table->pattern = $this->resultSql;

		$this->filteredSqlCount = [];
		$this->params = null;

		$this->filtered = [];
		foreach($this as $name => $section) {
			if($section->parse($params, $this->filteredSql)) {
				$this->filtered[$name] = true;
			}
		}
	}

	/**
	 * Some options have been selected in filter?
	 */
	function isFiltered() {
		return (bool) $this->filtered;
	}

	/**
	 *
	 */
	function isFilteredExcept($section) {
		return count($this->filtered) >= (isset($this->filtered[$section])?2:1);
	}

	/**
	 * The filter has already parsed params?
	 */
	function isParsed() {
		return (bool) $this->filteredSql;
	}

	/**
	 * Returns number of items that match the filter (regardless the limit and offset)
	 * echo "Found {$filter->getRecordCounts()} records";
	 */
	function getRecordsCount($field = null) {
		if($this->hasNoRecords) {
			return 0;
		}
		if(!$field) {
			$field = $this->getIdField();
		}

		if(!key_exists($field, $this->filteredSqlCount)) {
			$result = $this->result();
			$this->filteredSqlCount[$field] = (int) $this->getDbMole()->selectSingleValue(
					$result->select("COUNT(DISTINCT $field)",false),
					$result->bind
			);
		}
		return $this->filteredSqlCount[$field];
	}

	/** Returns number of items without any filter **/
	function getAllRecordsCount() {
		if($this->hasNoRecords) {
			return 0;
		}

		if($this->unfilteredSqlCount === null) {
			$result = $this->unfilteredSqlResult();
			$this->unfilteredSqlCount = (int) $this->getDbMole()->selectSingleValue(
					$result->select("COUNT(DISTINCT {$this->getIdField()})",false),
					$result->bind
			);
		}
		return $this->unfilteredSqlCount;
	}

	/** Returns number of items without any filter **/
	function unfilteredRecordExists() {
		if($this->hasNoRecords) {
			return false;
		}
		$result = $this->unfilteredSqlResult();
		return $result->select("EXIST {$this->getIdField()})",false);
	}



	/**
	 * Returns query and bind params for obtainings ids of filtered products
	 * Possible multiple occurences of id must be a bit specially handled by
	 * generating SQL
	 * list($sql, $bind) = $filter->resultQuery();
	 * Cards::FindAll([
			'conditions' => "id IN ({$result->select('id')})",
			'bind_ar' => $result->bind]);
	 */
	function resultQuery($sqlOptions = []) {
		$sql = $this->result($sqlOptions);
		return $query = [ $sql->distinctOnSelect( $this->getIdField() ), $sql->bind ];
	}

	/**
	 * Returns SQLResult object - sql query for obtaining ids of items that fits the filter
	 * $result = $filter->result(['limit' => 10]);
	 * Cards::FindAll([
			'conditions' => "id IN ({$result->select('id')})",
			'bind_ar' => $result->bind]);
	 */
	function result($sqlOptions = []) {
		if($this->hasNoRecords) {
			$fields = $this->getMaterializedFields('empty');
			if(!in_array($this->options['id_field'], $fields)) {
				$fields[] = $this->options['id_field'];
			}
			$fnames = implode(',', $fields);
			$fvalues = "NULL".str_repeat(",NULL", count($fields)-1);
			return new SqlResult(
				"(VALUES ($fvalues)) {$this->unfilteredSql->name}($fnames)",
				"FALSE"
			);
		}

		if(!$this->filtered) {
			return $this->unfilteredSql->result($sqlOptions);
		}


		return $this->resultSql->result($sqlOptions);
	}

	//INTERNAL METHODS

	/**
	 * Returns SqlResult object for query WITHOUT filter conditions
	 **/
	function unfilteredSqlResult($options = []) {
		return $this->unfilteredSql()->result($options);
	}

	/**
	 * Returns SqlResult object for query WITH filter conditions
	 */
	function filteredSqlResult($options = []) {
		return $this->filteredSql->result($options);
	}

	/**
	 * Returns full sql expression for id field of filtered table
	 * $filter->getIdField();
	 * >> cards.id
   */
	function getIdField() {
		return "{$this->getMainTableName()}.{$this->options['id_field']}";
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
		//invalidate sorted enabled sections
		$this->visibleSections = null;
	}

	function getParams() {
		if($this->params === null) {
			if($this->sections) {
				$f = function($v) { return $v->getParams();};
				$params = array_map($f, iterator_to_array($this));
				$this->params = call_user_func_array('array_merge', $params);
			} else {
				$this->params = [];
			}
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
			foreach($this as $section) {
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

	function visibleSections() {
		$sections = $this->sections;
		$sections = array_filter($sections, function($s) {return $s->isVisible();});
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
	function addAlwaysFalseCondition() {
			$this->addCondition("1=0");
			$this->hasNoRecords=true;
	}

	function sureHasNoRecords() {
			return $this->hasNoRecords;
	}

	function getMainTableName() {
			return $this->unfilteredSql->getTableName();
	}

	/**
	 * Return FilterLandingPage object, if just one section (with landing assigned page)
	 * filters the results, the section has l.p. assigned, and the l.p. matches the
	 * conditions (e.g. just one choice from the filter is choosed)
	 **/
	function landingPage() {
		$lp = false;
		foreach($this->sections as $s) {
			$p = $s->landingPage();
			if($p===false) {
				continue;
			}
			if($p===true || $lp) {
				return false;
			}
			$lp = $p;
		}
		return $lp;
	}

	function getLandingPagesFilterParams() {
		$out = array_map(function($section) {
			return (!$section->isFixed() && is_object($section->options['landing_page']))?
						$section->options['landing_page']->enumLandingPages($section) :
						[];
		}, iterator_to_array($this));
		return array_merge(...array_values($out));
	}
}
