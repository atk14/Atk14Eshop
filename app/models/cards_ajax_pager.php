<?php
require_once(dirname(__FILE__).'/../../lib/ajax_pager/ajax_pager.php');

class CardsAjaxPager extends AjaxPager {
	function __construct($controller, $options = []) {
		parent::__construct($controller, $options + [
			   'item_variable' => 'card',
				 'item_template' => 'shared/card_item',
				 'page_size' => 40,
				 'pages_per_section' => 4
		]);
	}
}
