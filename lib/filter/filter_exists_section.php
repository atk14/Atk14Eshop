<?php
/**
 * Filter section for one YES/NO value, where NO is indicated by nonexistence of given
 * left joined field.
 */

class FilterExistsSection extends FilterBoolSection {
	/*function __construct($filter, $name, $options) {
		parent::__construct($filter, $name, $options + [
		])
	}*/

	function sqlBoolValue() {
		$field = parent::sqlBoolValue();
		return "$field IS NOT NULL";
	}

	function sqlOptions($sql=null) {
		$out = parent::sqlOptions($sql) + ['override_join' => [$this->getMainJoin($sql)->getName() => 'left join']];
		return $out;
	}

	function addConditions($values, $sql=null) {
		if($values === 'yes') {
			$sql = $this->getMainJoin($sql);
			$sql->setJoinBy('JOIN');
			$sql->setActive(true);
			$op = '';
		} elseif($values === 'no') {
			$sql = $this->getMainJoin($sql);
			$sql->setActive(true);
			$sql->setJoinBy('LEFT JOIN');
			$this->filter->parsedSql->namedWhere(
				$this->name,
				parent::sqlBoolValue() . ' IS NULL'
			);
		}
	}

}
