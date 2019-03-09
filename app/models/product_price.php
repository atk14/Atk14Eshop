<?php
class ProductPrice {

	protected $data;
	protected $amount;
	protected $currency;
	protected $current_date;

	/**
	 * $pp = new ProductPrice([
	 *	[
	 *		"product_id" => 123,
	 *		"vat_percent"
	 *		"prices" => [...],
   *    "discount_percent" => 20.0,
	 *	]
	 * ],10,Currency::GetDefaultCurrency());
	 */
	function __construct($data,$amount,$currency,$current_date){
		$this->data = $data;
		$this->amount = $amount;
		$this->currency = $currency;
		$this->current_date = $current_date;
	}

	function priceExists(){
		return !!$this->_getPriceItem();
	}

	function getAmount(){
		return $this->amount;
	}

	function getVatPercent(){
		return $this->data["vat_percent"];
	}

	function getCurrency(){
		return $this->currency;
	}

	function getProduct(){
		return Cache::Get("Product",$this->data["product_id"]);
	}

	function getUnit(){
		return $this->getProduct()->getUnit();
	}

  //

	// Jednotkova cena bez zaokrouhleni
	function getRawUnitPrice($incl_vat = false){
    $price = $this->getRawUnitPriceBeforeDiscount();

    if(!is_null($price)){
      if($this->data["discount_percent"]){
        $price = $price - $this->data["discount_percent"] * ($price / 100.0);
				$price = round($price,INTERNAL_PRICE_DECIMALS);
      }

			$price = $this->_addVat($price,$incl_vat);
			$price = round($price,INTERNAL_PRICE_DECIMALS);

      return $price;
    }
	}

	function getRawUnitPriceInclVat(){
		return $this->getRawUnitPrice(true);
	}

	// Jednotkova cena
	function getUnitPrice($incl_vat = false){
		$price = $this->getRawUnitPrice($incl_vat);
		$price = $this->_roundUnitPrice($price);
    return $price;
	}

	function getUnitPriceInclVat(){
		return $this->getUnitPrice(true);
	}

	// Celkova cena
	function getPrice($incl_vat = false){
		$unit_price = $this->getUnitPrice($incl_vat);
		if(!is_null($unit_price)){
			return $this->_roundItemPrice($unit_price * $this->getAmount());
		}
	}

	function getPriceInclVat(){
		return $this->getPrice(true);
	}

	// Cena pred slevou bez zaokrouhleni
	function getRawUnitPriceBeforeDiscount($incl_vat = false){
		if($price_item = $this->_getPriceItem()){
      $price = (float)$price_item["price"];
			$price = $price / $this->_getCurrencyRate();

			$price = $this->_addVat($price,$incl_vat);

			return $price;
		}
	}

	function getRawUnitPriceBeforeDiscountInclVat(){
		return $this->getRawUnitPriceBeforeDiscount(true);
	}

	// Cena pred slevou
  function getUnitPriceBeforeDiscount($incl_vat = false){
		$price = $this->getRawUnitPriceBeforeDiscount($incl_vat);
		$price = $this->_roundUnitPrice($price);
		return $price;
  }

  function getUnitPriceBeforeDiscountInclVat(){
		return $this->getUnitPriceBeforeDiscount(true);
  }

  function getPriceBeforeDiscount($incl_vat = false){
		if(!is_null($p = $this->getUnitPriceBeforeDiscount($incl_vat))){
			return $this->_roundItemPrice($p * $this->getAmount());
		}
  }

  function getPriceBeforeDiscountInclVat(){
		return $this->getPriceBeforeDiscount(true);
  }

  //

  /**
   *  if($price->discounted()){
   *    // a! toto je sleva
   *  }
   */
  function discounted(){
    return $this->getUnitPrice()<$this->getUnitPriceBeforeDiscount();
  }

	function getDiscountPercent(){
		$price = $this->getUnitPriceBeforeDiscount();
		$discounted_price = $this->getUnitPrice();
		return round(100 * ($price - $discounted_price) / $price);
	}

	/**
	 *
	 * @return ProductPrice[]
	 */
	function getQuantityDiscounts(){
		$product = $this->getProduct();
		$unit = $product->getUnit();
		$minimum_quantity_to_order = $unit->getMinimumQuantityToOrder();

		if(!$product->quantityDiscountsEnabled()){
			return [];
		}

		$out = [];
		$quantities_taken = [];
		foreach($this->data["prices"] as $item){
			if($item["minimum_quantity"]<=$minimum_quantity_to_order){
				// toto bude zakladni cena
				continue;
			}

			$minimum_quantity = $item["minimum_quantity"];

			if(isset($quantities_taken[$minimum_quantity])){
				// Vice zaznamu se stejnym minimum_quantity maji ruzne ceny.
				// Serazeno jest to tak, ze nejvyhodnejsi cenu zachytime prvnim pruchodem.
				continue;
			}
			$quantities_taken[$minimum_quantity] = $minimum_quantity;

			$out[] = new ProductPrice($this->data,$minimum_quantity,$this->currency,$this->current_date);
		}
		$out = array_reverse($out);

		return $out;
	}

	function _getPriceItem(){
		$product = $this->getProduct();
		$amount = $this->amount;
		$minimum_quantity_to_order = $product->getMinimumQuantityToOrder();

		if(!$product->quantityDiscountsEnabled()){
			$amount = $minimum_quantity_to_order;
		}

		if($amount<$minimum_quantity_to_order){
			$amount = $minimum_quantity_to_order;
		}

		foreach($this->data["prices"] as $item){
			if($item["minimum_quantity"]<=$amount){
				return $item;
			}
		}
	}

	function getPricesData() {
		return $this->data + [ 'currency_rate' => $this->_getCurrencyRate() ];
	}

	function _addVat($price,$add_vat = true){
		if(is_null($price) || !$add_vat){ return $price; }
		return $price * (1.0 + $this->getVatPercent() / 100.0);
	}

	function _roundItemPrice($price){
		if(is_null($price)){ return null; }
		
		$currency = $this->getCurrency();
		return $currency->roundPrice($price);
	}

	function _roundUnitPrice($price){
		if(is_null($price)){ return null; }

		$precision = $this->getProduct()->getUnit()->getUnitPriceRoundingPrecision();
		return round($price,$precision);
	}

	function _getCurrencyRate(){
		return $this->currency->getRate($this->current_date);
	}
}
