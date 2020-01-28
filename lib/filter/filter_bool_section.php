<?php
/**
 *  Filter section for one boolean SQL value, that can be filtered for both YES and NO
 *
 *  Section for filtering based on bool value
 *  new FilterRangeSection($filter, 'p', [
 *      'field' => 'price',
 *  ]);
 */

class FilterBoolSection extends FilterBaseSection {

	function __construct($filter, $name, $options) {
		$options = $options + [
			'field' => 'id',   //e.g. price
			#forms framework support
			'form_initial' => '',
			'form_field' => 'FilterBoolField',                  # name of FormField to be created by createFormFields
			'form_field_options' => [ 'label' => $name, 'choices' =>
			[
				'' => _('Vše'),
				'yes' => _('Ano'),
				'no' => _('Ne')
			]
			],# options passed to createFormFields
		];

		parent::__construct($filter, $name, $options);
		$this->emptyCounts = null;
		$this->counts = null;
	}

	/**
	 * Create a form field(s) for current section
	 *
	 * foreach($section->createFormFields() as $field) {
	 *   $form->add_field($field);
	 * }
	 */
	function createFormFields() {
		if($this->fixed) {
			return [];
		}
		$name = $this->getParamName();
		$class = $this->options['form_field'];
		$out = [];

		if($class && count($this->getEmptyCounts()) > 1) {
			$out[$name] = new $class(
				$this->formFieldOptions() +
				$this->options['form_field_options']
			);
		}
		return $out;
	}

	/*
	 * Return options for created form field
   */
	function formFieldOptions() {
		 $counts = $this->getEmptyCounts();
		 $out = [
			 'filter_section' => $this,
		 ];
		 if(count($counts)==1) {
			 $out['disabled'] = true;
			 $out['initial'] = key($counts);
		 }
		 return $out;
	}

	/**
	 * Parse values (e.g. from form)
	 * Called by Filter::parse()
	 */
	function parse($values) {
		$pname = $this->getParamName();
		$this->counts = null;
		if(!key_exists($pname, $values)) {
			$this->values='';
			return false;
		} else {
			$this->values = $values[$pname];
		}
		$this->addConditions($this->values);
		return $this->values !== '';
	}

	function sqlBoolValue() {
		$field = $this->options['field'];
		if(preg_match('/^[a-z0-9_]+$/', $field)) {
			$field = "{$this->getMainJoin($this->filter->emptySql())->getTableName()}.$field";
		}
		return $field;
	}

	function sqlOptions($sql=null) {
		return [
			'sql_options' => [
					'group' => 1,
				 'limit' => null,
				 'offset' => null,
			],
			'active_join' => $this->joins,
			'disable_where' => $this->name
		];
	}

	function getCounts() {
		if(!$this->filter->isFiltered()) {
			return $this->getEmptyCounts();
		}
		if($this->counts === null) {
			$this->counts = $this->getCountsOn($this->filter->parsedSql());
		}
		return $this->counts;
	}

	function getEmptyCounts() {
		if($this->emptyCounts === null) {
			$this->emptyCounts = $this->getCountsOn($this->filter->emptySql());
		}
		return $this->emptyCounts;
	}

	function getCountsOn($sql) {
		$field = $this->sqlBoolValue();
		$idfield = $this->filter->getIdField();
		$options = $this->sqlOptions($sql);
		$result = $sql->result($options);
		$query = $result->select("$field, count(DISTINCT $idfield)");
		$result = $this->getDbMole()->selectIntoAssociativeArray($query, $result->bind);

		if(count($result) > 1) {
			return [
				'yes' => $result['t'],
				'no' => $result['f'],
				'' => $result['t'] + $result['f']
			];
		}
		if(count($result)) {
				return [ key($result) == 't'?'yes':'no' => current($result) ];
		}
		return ['' => 0 ];
	}

	/***
	 * Add conditions to ParsedSqlResult based on given values
	 **/
	function addConditions($values, $sql=null) {
		if(!$values) { return; }
		$op = $values === 'yes' ? '' : 'NOT ';

		$sql = $this->getMainJoin($sql);
		$sql->namedWhere(
			$this->name,
			$op . $this->sqlBoolValue()
		);
	}

	/**
	 * Return array of active filter choices - in this case it can have only one item
	 * [ ['params' => <remaining params to generate "remove choice URL">, 'label' => 'label of choice' ]]
	 */
	function getActiveFilters($params) {
		if($this->values != '') {
			unset($params[$this->getParamName()]);
			return [[
				'params' => $params,
				'label' => $this->getFilteredLabel()
			]];
		} else {
			return [];
		}
	}

	function getFilteredLabel() {
		return $this->options['form_field_options']['choices'][$this->values];
	}
}
