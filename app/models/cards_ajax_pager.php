<?php
require_once(dirname(__FILE__).'/../../lib/ajax_pager/ajax_pager.php');

class CardsAjaxPager extends AjaxPager {
	function __construct($controller, $options = []) {
		// $item_template = "shared/card_item";
		$item_template = "shared/card_item_add_to_basket";
		parent::__construct($controller, $options + [
			   'item_variable' => 'card',
				 'item_template' => $item_template,
				 'page_size' => 40,
				 'pages_per_section' => 4
		]);
	}
}
