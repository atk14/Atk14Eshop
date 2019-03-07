<?php
class PriceFinder {

	protected $user;
	protected $currency;
	protected $current_date;
	protected $pricelist;
	protected $dbmole;

	static $PriceFinders=[];

	protected function __construct($user,$currency = null,$current_date = null){
		$this->user = $user;
		if(!$currency){
			$currency = Currency::GetDefaultCurrency();
		}
		if(is_null($current_date)){
			$current_date = now();
		}
		$this->pricelist = Pricelist::GetDefaultPricelist();
		$this->dbmole = Pricelist::GetDbmole();
		$this->currency = $currency;
		$this->current_date = $current_date;
		$this->priceData = new CacheSomething([$this, 'getPriceDataFor'], 'product');
	}

	static function GetInstance($user = null,$currency = null,$current_date = null){
		if(!$currency){
			$currency = Currency::GetDefaultCurrency();
		}
		if(!$current_date){
			$current_date = date("Y-m-d H:i");
		}
		$id = $user ? $user->getId() : '';
		$hash = $id."/".$currency->getCode()."/".$current_date;
		if( !key_exists($hash, self::$PriceFinders) ) {
			 self::$PriceFinders[$hash] = new PriceFinder($user,$currency,$current_date);
		}
		return self::$PriceFinders[$hash];
	}

	/**
	 *	$price = $price_finder->getPrice
	 */
	function getPrice($product,$amount = null,$options = []){
		$options += [
			"return_null_when_price_does_not_exist" => true,
		];

		if(is_null($amount)){
			$amount = $product->getUnit()->getMinimumQuantityToOrder(); // 1ks nebo 10cm
		}

		$data = $this->_getPriceData($product);
		$price = new ProductPrice($data,$amount,$this->currency,$this->current_date);
		if($options["return_null_when_price_does_not_exist"] && !$price->priceExists()){
			return null;
		}
		return $price;
	}

	function getCurrency(){ return $this->currency; }

	protected function _getPricelist(){
		return Pricelist::GetDefaultPricelist();
	}

	protected function _getPriceData($product, $options=[]){
		return $this->priceData->get($product, $options);
	}

	function getPriceDataFor($ids, $options) {

		$rows = $this->dbmole->selectRows("SELECT product_id,price,minimum_quantity FROM pricelist_items WHERE pricelist_id=:pricelist AND product_id IN :product ORDER BY product_id, minimum_quantity DESC, price ASC",[
			":product" => $ids,
			":pricelist" => $this->pricelist
		]);
		$products = Cache::Get('Product', array_combine($ids, $ids));
		$prices = [];
		foreach($rows as $row) {
			$p_id = $row["product_id"];
			if(!isset($prices[$p_id])){ $prices[$p_id] = []; }
			$prices[$p_id][] = $row;
		}

		$discount_percent = Discount::GetDiscountForProduct($ids);
		$out = [];
		foreach($ids as $id) {
			$out[$id] = [
				"product_id" => $id,
				"vat_percent" => $products[$id] ? $products[$id]->getVatPercent() : null,
				"discount_percent" => $discount_percent[$id],
				"prices" => isset($prices[$id]) ? $prices[$id] : []
			];
		}
		return $out;
	}
}
