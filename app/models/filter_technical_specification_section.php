<?php
/***
 * Filter section
 *
 * new FilterCategorySection($filterCategory);
 */
class FilterTechnicalSpecificationSection {

	static function CreateNew($filter, $name, $ts_key =[], $bind_ar = []) {

		if($name instanceof TechnicalSpecificationKey) {
			$bind_ar = $ts_key;
			$ts_key = $name;
			$name = 'ts'.$ts_key->getId();
		}
		$bind_ar[":{$name}_key"] = $ts_key->getId();

		$join = $filter->addJoin("technical_specifications {$name}")->
			where("cards.id = {$name}.card_id")->
			where("{$name}.technical_specification_key_id = :{$name}_key")->
			bind($bind_ar);

		$code = $ts_key->getType()->getCode();
		if($code == 'integer') {
			$class = 'FilterRangeSection';
			$field = "(content_json->>'integer')::integer";
		}
		if(!$class) {
			throw new Exception("I do not know how to build filter from the technical specifications of type $code");
		}

		return new $class($filter, $name, [
			'join' => $join,
			'field' => $field,
			'form_label' => $ts_key->getKey()
			#'label_class' => 'Category'
		]);
	}
}
