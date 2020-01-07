<?php
class FilterSection extends FilterChoiceSection {
	function __construct($filter, $name, $options) {
		$options += [
			'field' => null,				//e.g. 'brand_id' -- choices will be the possible values of the field
			'order' => null,				//order of returned coices
			'condition' => null,		//condition that limit choices

			'label_class' => null,
			'label_method' => 'getName',

			#commonly no need for redefining
					#choices are readed dynamically
			'form_field_options' => [ 'label' => $name, 'choices' => null ],
			'not_null' => null,			//condition on field not null. Default value !condition_over_subtable
		];
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
		$distinct = $field . ($orderfield?',':'') . $orderfield;

		$sql = $result->select(
				"DISTINCT ON($distinct) $field",
				['order' => $orderfield?:$field,
		     'add_options' => false]
	  );
		$out = $this->getDbMole()->selectIntoArray($sql, $result->bind);
		return $out;
	}

	/***
	 * Returns all fields that are needed by this table
   **/
	function getUsedFields() {
		$out = $this->options['order']?
							$this->stripFieldNames(explode(',', $this->options['order'])):
							[];
		$out[] = $this->options['field'];
		return $out;
	}

	/**
	 * Returns counts of filtered items restricted by a given SQLResult object.
	 */
	function getCountsOn($sql) {
		if($this->options['condition']) {
			$sql->andWhere($this->options['condition']);
		}
		$id = $this->filter->getIdField();
		$field = $this->getSqlField();
		$query = $sql->select(
				"$field, COUNT(DISTINCT $id)",
				[ 'group' => $field,
					'add_options' => false,
				]
				);
		$out = $this->getDbMole()->selectIntoAssociativeArray($query, $sql->bind);
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
		if(preg_match('/^[a-z0-9_]+$/', $field)) {
			$field = "{$this->getMainJoin($this->filter->emptySql)->getTableName()}.$field";
		}
		return $field;
	}

	/**
	 * Add conditions to ParsedSqlResult based on given values
	 **/
	function addConditions($values, $sql=null) {
		if(!$values) { return; }
		$condition = "{$this->getSqlField()} IN :{$this->name}";
		$sql = $this->getMainJoin($sql);
		$sql->namedWhere($this->name, $condition)->bind(":{$this->name}", $values);
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

			if($method) {
				foreach($objs as &$v) {
					$v = $v->$method();
				}
			}
			$this->choiceLabels = $objs;
		}
		return $this->choiceLabels;
	}
}
