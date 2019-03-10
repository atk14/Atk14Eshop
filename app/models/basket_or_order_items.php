<?php
/***
Base objekt pro položky košíku či objednávky. Jde iterovat, a poskytuje metody pro přednačtení
různých věcí.
**/

class BasketOrOrderItems extends ArrayObject {
	protected $basket_or_order = null;

	var $products = null;
	var $cards = null;
	var $cardIds = null;

	function __construct($basket_or_order,$items){
		$this->basket_or_order = $basket_or_order;
		parent::__construct($items);
		$this->_prepareCaches();
	}

	/** Přednačte všechny použité značky. Pro GMT **/
	function prereadBrands() {
		if(!$this->prereadedBrands) {
			$cards = array_map(function($v) {return $v->getBrandId();}, $this->getCards());
			Cache::Prepare('Brand', $cards);
			$this->prereadedBrands = true;
		}
	}

	/** Vrátí id všech karet **/
	function getCardIds() {
		if($this->cardIds === null) {
			$this->cardIds = array_map(function($v) {return $v->getCardId();}, $this->getProducts());
		}
		return $this->cardIds;
	}

	/** Vrátí a zacachuje všechny karty **/
	function getCards() {
		if($this->cards === null) {
			$this->cards = Cache::Get("Card", $this->getCardIds());
		}
		return $this->cards;
	}

	function getProductIds() {
		return array_map(function($v) {return $v->getProductId();}, (array) $this);
	}

	protected function _prepareCaches(){
		Cache::Prepare('Product', $this->getProductIds());
		foreach(Cache::Get('Product',$this->getProductIds()) as $product){
			Cache::Prepare('Card',$product->getCardId());
		}
	}
}
