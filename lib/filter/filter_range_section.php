<?php
/**
 *  Section for filtering based on range, e.g. price
 *  new FilterRangeSection($filter, 'p', [
 *      'field' => 'price',
 *  ]);
 */

class FilterRangeSection extends FilterBaseSection {

	function __construct($filter, $name, $options) {
		$options = $options + [
			'field' => null,                                    //e.g. price

			#forms framework support
			'form_field' => 'FilterRangeField',                  # name of FormField to be created by createFormFields
			'form_field_options' => [ 'label' => $name, 'choices' => [] ],# options passed to createFormFields
			'main_table_fields' => []
		];

		$this->possibleRange = null;
		$this->availableRange = null;
		parent::__construct($filter, $name, $options);
	}

	/**
	 * Returns range of possible values of filtered field, where no filter is applied.
	 * $section->getPossibleRange();
	 * >> [ 'min' => 1, 'max' => 10 ]
	 * Returns [] if no suitable item is given.
	 */
	function getPossibleRange() {
		if(!$this->possibleRange) {
			$this->possibleRange = $this->getRangeOn($this->filter->unfilteredSql());
		}
		return $this->possibleRange;
	}

	/**
	 * Returns range of possible values of filtered field, where the filter
	 * is applied (regardless of the settings of this section)
	 * $section->getAvailableRange();
	 * >> [ 'min' => 3, 'max' => 10 ]
	 */
	function getAvailableRange() {
		if($this->availableRange === null) {
			if($this->filter->isFilteredExcept($this->name)) {
				$this->availableRange = $this->getRangeOn(
					$this->filter->filteredSql
				);
			} else {
				$this->availableRange = $this->getPossibleRange();
			}
		}
		return $this->availableRange;
	}

	/**
	 * Returns range of possible values of filtered field, where the filter is applied,
	 * however, enlarged so it covers $this->value
	 * $section->getEffectiveRange();
	 * >> [ 'min' => 1, 'max' => 15 ]
   */
	function getEffectiveRange() {
		if(!$this->isParsed()) {
			return $this->getPossibleRange();
		}
		$range = $this->getAvailableRange();

		if($this->values && $range) {
			$range = $this->mergeRanges($range, $this->values);
		}
		return $range;
	}

	/***
	 * Merge ranges - returns the range that covers the both ranges
	 * $ $this->mergeRanges(['min' => 1, 'max' => 5],['min' =>3, 'max' =>6])
	 * > ['min' => 1, 'max'=> 6]
	 **/
	function mergeRanges($a, $b) {
		if($a['min'] > $b['min']) {
			$a['min']=$b['min'];
		}
		if($a['max'] < $b['max']) {
			$a['max']=$b['max'];
		}
		return $a;
	}

	/*
	 * Is there any valid value for this section
	 */
	function isPossible() {
		$range = $this->getPossibleRange();
		return $range && $range['min'] < $range['max'];
	}

	/*
	 * Return options for created form field
   */
	function formFieldOptions() {
		 $range = $this->getPossibleRange();
		 $out = [
			 "min_value" => $range['min'],
			 "max_value" => $range['max'],
			 'initial' => $range,
			 'disabled' => !$range
		 ] + parent::formFieldOptions();
		 return $out;
	}

	/**
	 * Parse values (e.g. from form)
	 * Called by Filter::parse()
	 */
	function parseValues($values) {
		$pname = $this->getParamName();
		$this->availableRange = null;
		if(!key_exists($pname, $values) || !$ar=$this->getPossibleRange()) {
			$this->values=[];
		} else {
			$this->values = $values[$pname];
			$this->values = array_intersect_key(  $this->values, ['min' => 0, 'max' => 0]);
			if( !isset($this->values['min']) || $this->values['min'] <= $ar['min']) {
				unset( $this->values['min'] );
			}
			if( !isset($this->values['max']) || $this->values['max'] >= $ar['max']) {
				unset( $this->values['max'] );
			};
		}
	}

	/**
	 * Add conditions to ParsedSqlResult based on given values
	 **/
	function getConditions($values) {
		if(!$values) { return [null,null]; }
		if(!$ar=$this->getPossibleRange()) { return [null,null]; }
		$values += $ar;

		$bind = [];
		if(key_exists('min', $values)) {
			$bind[":{$this->name}_min"] = $values['min'];
			if(key_exists('max', $values)) {
				$condition="{$this->getSqlField()} BETWEEN :{$this->name}_min AND :{$this->name}_max";
				$bind[":{$this->name}_max"] = $values['max'];
			} else {
				$condition = "{$this->getSqlField()} >= :{$this->name}_min";
			}
		} elseif(key_exists('max', $values)) {
				$bind[":{$this->name}_max"] = $values['max'];
				$condition = "{$this->getSqlField()} <= :{$this->name}_max";
		} else {
				$condition = null;
		}
		return [ $condition, $bind ];
	}

	/**
	 * Returns range of filtered value - restricted by a given SQLResult object.
	 */
	function getRangeOn($sql) {
		$result = $sql->result($this->sqlOptions(true));
		$field = $this->getSqlField();

		$sql = $result->select(
				"MIN($field) as min, MAX($field) as max",
				['add_options' => false]
			);
		$out = $this->getDbMole()->selectFirstRow($sql, $result->bind);
		if(!$out) {
			return [];
		}
		$out = array_map(function($v) { return $v===null? $v : (int) $v;} , $out);
		if( $out['min'] === null && $out['max'] === null ) {
			return [];
		}
		return $out;
	}

	/**
	 * Return array of active filter choices - in this case it can have only one item
	 * [ ['params' => <remaining params to generate "remove choice URL">, 'label' => 'label of choice' ]]
	 */
	function getActiveFilters($params) {
		if($this->values) {
			unset($params[$this->getParamName()]);
			return [[
				'params' => $params,
				'label' => $this->getFilteredLabel()
			]];
		} else {
			return [];
		}
	}

	/**
	 * Return label that include currently filtered range
	 * $this->getFilteredLabel();
	 * > Price (90-120)
	 */
	function getFilteredLabel() {
		$out = $this->options['form_field_options']['label'];
		if(isset($this->values['min'])) {
			if(isset($this->values['max'])) {
				return $out. " ({$this->values['min']} - {$this->values['max']})";
			} else {
				return $out.' '. _('from'). " {$this->values['min']}";
			}
		} else {
			if(isset($this->values['max'])) {
				return $out.' '. _('to'). " {$this->values['max']}";
			}
		}
		return $out;
	}
}
