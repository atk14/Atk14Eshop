<?php
class FilterSection extends FilterChoiceSection {
	function __construct($filter, $name, $options) {
		$options += [
			'field' => null,				//e.g. 'brand_id' -- choices will be the possible values of the field
			'order' => true,				//order of returned coices
			'order_after_distinct' => true,
			'condition' => null,		//condition that limit choices

			'label_class' => null,
			'label_method' => 'getName',

			#commonly no need for redefining
					#choices are readed dynamically
			'form_field_options' => [],
			'not_null' => null,			//condition on field not null. Default value !condition_over_subtable
		];
		$options['form_field_options'] += [ 'choices' => null ]; # options passed to createFormFields
		parent::__construct($filter, $name, $options);
		if($this->options['not_null'] === null) {
			$this->options['not_null'] = !$this->options['condition_over_subtable'];
		}
	}

	/**
	 * Returns the choices - possible values of filter section - restricted by a given SQLResult object.
	 */
	function getChoicesOn($sql) {
		$result = $sql->result($this->sqlOptions(true));
		if($this->options['condition']) {
			$result->andWhere( $this->options['condition'] );
		}

		$field = $this->getSqlField();
		$orderfield = $this->getSqlField('order');
		if(!is_string($orderfield)) {
			$orderfield=null;
		}

		if($this->options['order_after_distinct']) {
			$sql = $result->select("DISTINCT $field",[
				'add_options' => false
			]);
			$bind = $result->bind;
			if($orderfield) {
				$sql = "SELECT * FROM ($sql) _q ORDER BY $orderfield";
			}
		} else {
			list($sql, $bind) = $result->distinctOnSelect(
					$field,
					['order' => $orderfield,
					 'add_options' => false]
			 );
		}
		$out = $this->getDbMole()->selectIntoArray($sql, $bind);
		return $out;
	}

	/***
	 * Returns all fields that are needed by this table
   **/
	function getUsedFields() {
		$out = is_string($this->options['order'])?
							\SqlBuilder\FieldsUtils::StripFields($this->options['order']):
							[];
		$out[] = $this->options['field'];
		return $out;
	}

	function isAditive() {
		return true;
	}

	/**
	 * Returns counts of items restricted by a given SQLResult object for each available
	 * choice.
	 * If $where is given, then the counts are further restricted by the condition
	 */
	function getCountsOn($sql, $where=null) {
		$id = $this->filter->getIdField();
		if($this->options['condition']) {
			$sql->andWhere($this->options['condition']);
		}
		if($where) {
			$count = "COUNT(DISTINCT CASE WHEN $where THEN $id ELSE NULL END)";
		} else {
			$count = "COUNT(DISTINCT $id)";
		}
		$field = $this->getSqlField();
		$query = $sql->select(
				"$field, $count",
				[ 'group' => $field,
					'add_options' => false,
				]
				);
		$out = $this->getDbMole()->selectIntoAssociativeArray($query, $sql->bind);
		$out = array_map("intval", $out);
		return $out;
	}

	function sqlOptions($disable_where = false) {
		$out = parent::sqlOptions($disable_where);
		if($this->options['not_null']) {
			$out['add_where'] = "{$this->getSqlField()} IS NOT NULL";
		}
		return $out;
	}

	/**
	 * Return SQL full name of filtered field
	 * $brands = $filter->addJoin('brands', .... );
	 * $section = new FilterSection($filter, 'name', ['field' => 'id', join => $brands ]);
	 * $section->getSqlField()
	 * > 'cards.id'
	 */
	function getSqlField($field = 'field') {
		$field = $this->options[$field];
		if(!is_string($field)) {
			return $field;
		}
		if(preg_match('/^[a-z0-9_]+$/', $field)) {
			$field = "{$this->getMainJoin($this->filter->unfilteredSql)->getTableName()}.$field";
		}
		return $field;
	}

	function getConditions($values) {
		$condition = "{$this->getSqlField()} IN :{$this->name}";
		return [$condition, [":{$this->name}" => $values]];
	}

	/**
	 * Return labels for checkboxes
	 * @returns array [ 'choice_id_1' => 'Choice label', ..... ]
	 */
	function getChoiceLabels() {
		if($this->choiceLabels === null) {
			$class = $this->options['label_class'];
			$method = $this->options['label_method'];
			if(!$class) {
				return [];
			}
			$choices = $this->getPossibleChoices();
			$choices = array_combine($choices, $choices);
			$objs = $class::GetInstanceById($choices, ['use_cache' => true]);
			if(isset($this->options['label_preprocess'])) {
				$objs = $this->options['label_preprocess']($objs);
			}

			$order = $this->options['order'];
			if(is_callable($order) && !is_string($order)) {
				uasort($objs, $order);
			}

			if($method) {
				if($method instanceof Closure) {
					foreach($objs as &$v) {
						$v = $method($v);
					}
				} else {
					foreach($objs as &$v) {
						$v = $v->$method();
					}
				}
			}
			if($order === true) {
				uasort($objs, 'strcoll');
			}
			$this->choiceLabels = $objs;
		}
		return $this->choiceLabels;
	}
}
