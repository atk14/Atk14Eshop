<?php
/***
 * Filter section
 *
 * new FilterCategorySection($filterCategory);
 */
class FilterCategorySection extends FilterSection {
	function __construct($filter, $name, $category =[], $bind_ar = []) {
		if($name instanceof Category) {
			$bind_ar = $category;
			$category = $name;
			$name = 'c'.$category->getId();
		}

		$bind_ar[":{$name}_parent"] = $category->getId();
		$condition = "$name.parent_category_id = :{$name}_parent and $name.visible";
		$join = $filter->addJoin("(category_cards {$name}__cc JOIN categories $name ON ({$name}__cc.category_id = $name.id))")->
			where("cards.id = {$name}__cc.card_id")->
			where($condition)->
			bind($bind_ar);

		parent::__construct($filter, $name, [
			'join' => $join,
			'field' => 'id',
			'order' => 'rank',
			'form_label' => $category->getName(),
			'label_method' => 'getName',
			'label_class' => 'Category'
		]);
	}
}
