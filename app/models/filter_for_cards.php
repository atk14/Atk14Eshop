<?php
/***
 * //Condition for cards in given subtree
 * list($cond, $bind) = $category->sqlConditionForCardsIdBranch('cards.id');
 *
 * //Create filter
 * $filter = new FilterForCards([
 *    'offset' => $this->params->g('offset'),
 *    'conditions' => $cond,
 *    'bind' => $bind,
 *    'category_first' => $category->getId()
 * ]);
 * //Set filter data
 * $filter->parse($this->params);
 * //Obtain result
 * $records = new FilterFinder($filter)->getRecords();
 *
 * For more see Filter class
 **/

class FilterForCards extends Filter {

	var $productJoin;

	function __construct($user, $options = []) {
		$options += [
			"conditions" => null,
			"category" => null,     //Z ktere kategorie se maji pridat filtry - a take se davaji karty z teto
															//kategorie prvni
			"order" => '',
			"limit" => 50,
			"add_sections" => true,
			"add_others" => true,
			"model" => 'Card',
			"currency" => null
		];
		parent::__construct('cards', $options);
		$this->addCondition("cards.visible AND NOT cards.deleted");
		$this->addBind(':user_id', $user);
		//$this->productJoin = $this->addJoin("visible_products(:user_id) products")->where("products.card_id = cards.id")->setJoinBy('left join');
		$this->productJoin = $this->addJoin("products")->where("products.card_id = cards.id AND NOT products.deleted AND products.visible")->setJoinBy('left join');

		//Add filter sections
		if($options['add_sections']) {
			// In case that products (cards) are displayed by a brand and not by a category,
			// filters can be taken from the root category, if such category exists.
			$category = $options["category"] ? $options["category"] : Category::MainRootCategory();
			if($category){
				$sections = $category->getAvailableFilters(["visible" => true]);
				foreach($sections as $section) {
					new FilterCategorySection($this, $section->getFilterName(), $section);
				}
			}

			//Add filter technical specification
			$tss = TechnicalSpecificationKey::FindByCodes([
				"w" => "width",
			]);
			foreach($tss as $k => $ts) {
				if($ts) {
					FilterTechnicalSpecificationSection::CreateNew($this, $k, $ts);
				}
			}
		}

		/*if($options['add_others']) {
			//Price
			$currency = $options['currency']?:Currency::GetInstanceByCode('CZK');
			$rate = (float) $currency->getRate();
			new FilterRangeSection($this, 'p', [
				'field' => "price/$rate",
				'join' => $j=$this->productJoin->join("user_basic_prices(:user_id) ubp")->where("products.id = ubp.product_id")->setJoinBy('LEFT JOIN'),
				'form_label' => sprintf(_('Cena za metr či kus (%s)'), $currency->getSymbol() ),
				'form_widget_options' =>
						['step' => $rate > 10 ? 0.1 : 1,
						 'format' => 'price',
						 'format_arguments' => [ $currency->getDecimalsSummary(), ''] #, ' '.$currency->getSymbol() ]
						]
			]);
		}*/

		//Sorting
		if($options['category']) {
				$order = "(SELECT DISTINCT ON (card_id) ROW
								(category_id <> :category_first, -- napred karty zarazene primo v dane kategorii
								 rank,
								 id
								)
				 FROM category_cards WHERE card_id = cards.id ORDER BY card_id, category_id, rank, id)";
				$this->addBind(':category_first', $options['category']);
		} else {
				$order = "cards.id";
		}
		if($options['order']) {
			$options['order'] .= ", $order";
		} else {
			$options['order'] = $order;
		}
		$this->setSqlOptions(array_intersect_key($options, ['limit' => true, 'offset' => true, 'order'=> true]));
	}
}
