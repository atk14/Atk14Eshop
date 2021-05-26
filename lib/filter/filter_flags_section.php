<?php
class FilterFlagsSection extends FilterChoiceSection {
/**
 *       FilterSection for flags - boolean values given by SQL expression
 *
 *       $flags = new FilterFlagsSection($this, 'flags', [
 *         'join' =>  $this->addJoin("product pp")->where("main.product_id = pp.id"),
 *         'operator' => 'AND',
 *         'form_choices' => [
 *           'flag_green_product' => 'Ekologický produkt',
 *           'flag_czech_product' => 'CZ zboží',
 *           'flag_product_with_present' => 'zboží s dárkem',
 *           'flag_new' => 'pro leváky',
 *           'flag_sale' => 'akční zboží'
 *         ],
 *         'field_expressions' => function($v) { return "$v = 'Y'";},
 *         'form_label' => 'Zboží...'
 *       ]);
 */

	var $fields = null;
	var $fixedFields = null;
	var $fixedValues = null;

	function __construct($filter, $name, $options) {
		parent::__construct($filter, $name, $options);
		$this->options += [
			'fields' => null,      //e.g. [ is_active, action_item => "CAST(table.action_item AS BOOL)" ] -- choices are given boolean fields
			'visible_choices' => null, #If it is set, limit displayed choices by the given list
			'fixed_values' => [],
			'operator' => 'OR',
			'field_expression' => null,
			'field_expressions' => [],
		];

		if(key_exists('choices', $this->options['form_field_options']) && !$this->options['fields']) {
			$this->options['fields'] = array_keys($this->options['form_field_options']['choices']);
		}

		$this->fields = [];
		foreach($this->options['fields'] as $k => $v) {
			if(is_int($k)) {
				$k = $v;
				if(key_exists($k, $this->options['field_expressions'])) {
					$v = $this->options['field_expressions'][$k];
				} elseif($this->options['field_expression']) {
					$v = $this->options['field_expression']($v);
				}
			}
			$this->fields[$k] = $v;
		}
		$this->setOperator($this->options['operator']);
		if( $this->options['visible_choices'] === null) {
			$this->visibleFields = $this->fields;
		} else {
			$this->visibleFields = array_intersect_key($this->fields, array_flip($this->options['visible_choices']));
		}
		if($this->options['fixed_values']) {
			$this->setFixedValues($this->options['fixed_values']);
		}
	}

	function getVisibleFields() {
		return $this->visibleFields;
	}

	function isAditive() {
		return ! $this->andOperator;
	}

	function setFixedValues($values) {
		if(!is_array($values)) {
			$values = [ $values ];
		}
		$this->fixedValues = $values;
		if($this->fields) {
			$this->addConditions($values, $this->filter->unfilteredSql);
			$fvalues = array_flip($values);
			#$this->fields = array_diff_key($this->fields, $fvalues);
			if($this->forceChoices) {
				$this->forceChoices = array_diff_key($this->fields, $fvalues);
			}
			$this->visibleFields = array_diff_key($this->visibleFields, $fvalues);
		}
	}

	function setOperator($operator) {
		$this->operator = $operator;
		$this->andOperator = strtoupper($operator) == 'AND';
	}

	function getChoicesOn($sql) {
		$result = $sql->result($this->sqlOptions(!$this->andOperator));
		foreach($this->visibleFields as $k => $v) {
				$fields[] = "bool_or($v) AS $k";
		}
		$sql = $result->select(implode(',', $fields), false);
		$out = $this->getDbmole()->selectRow($sql, $result->bind);
		$out = array_keys(array_filter($out, function($v) {return $v === 't';}));
		return $out;
	}

	function getUsedFields() {
		return array_values(\SqlBuilder\FieldsUtils::StripFields($this->fields));
	}

	function getCountsOn($sql, $where=null) {
		if($where) {
			$where = " AND $where";
		}
		foreach($this->getVisibleFields() as $k => $v) {
			$fields[] = "($v$where)::integer AS $k";
			$results[] = "sum($k) AS $k";
		}
		$field = $this->filter->getIdField();
		$fields[] = "$field AS __id";
		$query = $sql->select("DISTINCT " . implode(',', $fields));
		$query = "SELECT " . implode(',', $results) . " FROM ($query) _q";
		$out = $this->getDbmole()->selectRow($query, $sql->bind);
		return array_map("intval", array_filter($out));
	}

	function getConditions($values) {
		$values = array_intersect_key( $this->fields, array_flip($values) );
		if(!$values) { return; }
		$conditions = "(" . implode(" {$this->operator}  ", $values). ")";
		return [$conditions, []];
	}
}
