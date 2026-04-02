<?php
class BasketItems extends BasketOrOrderItems {

	var $prereadedProducts = false;
	var $catalogIds = null;
	var $parent = null;

	function __construct($basket) {
		$items = BasketItem::FindAll("basket_id", $basket, array("use_cache" => true, "order_by" => "rank, id"));
		parent::__construct($basket,$items);
	}
}
