<?php
class PriceFinder {

	use TraitPriceManipulation;

	protected $user;
	protected $currency;
	protected $current_date;
	protected $pricelist;
	protected $base_pricelist;
	protected $dbmole;

	static $PriceFinders = [];
	static protected $CurrentInstance = null;

	protected function __construct($user = null,$currency = null,$current_date = null){
		if(!$user){
			$user = User::GetAnonymousUser();
		}
		if(!$currency){
			$currency = Currency::GetDefaultCurrency();
		}
		if(is_null($current_date)){
			$current_date = now();
		}
		$this->user = $user;
		$this->pricelist = $user->getPricelist();
		$this->base_pricelist = $user->getBasePricelist();
		if($this->base_pricelist && $this->base_pricelist->getId()==$this->pricelist->getId()){ $this->base_pricelist = null; }
		$this->dbmole = Pricelist::GetDbmole();
		$this->currency = $currency;
		$this->current_date = $current_date;
		$this->priceData = new CacheSomething([$this, 'getPriceDataFor'], 'Product');
	}

	static function GetInstance(){
		$args = func_get_args();
		$instance_key = self::_ArgsToInstanceKey($args);
		if( !key_exists($instance_key, self::$PriceFinders) ) {
			// ReflectionClass cannot be used here, because the __construct is protected
			if(sizeof($args)>=3){
				$instance = new PriceFinder($args[0],$args[1],$args[2]);
			}elseif(sizeof($args)==2){
				$instance = new PriceFinder($args[0],$args[1]);
			}elseif(sizeof($args)==1){
				$instance = new PriceFinder($args[0]);
			}else{
				$instance = new PriceFinder();
			}
			self::$PriceFinders[$instance_key] = $instance;
		}
		return self::$PriceFinders[$instance_key];
	}

	protected static function _ArgsToInstanceKey($args){
		$out = [];
		foreach($args as $arg){
			if(is_array($arg)){
				$out[] = self::_ArgsToInstanceKey($arg);
				continue;
			}
			$class = is_object($arg) ? get_class($arg) : "";
			$value = is_a($arg,"TableRecord") ? $arg->getId() : "$arg";
			$out[] = "$class:$value";
		}
		return join(";",$out);
	}

	static function GetCurrentInstance(){
		if(self::$CurrentInstance){
			return self::$CurrentInstance;
		}
		return self::GetInstance();
	}

	static function SetCurrentInstance($price_finder){
		myAssert(is_a($price_finder,"PriceFinder"));
		self::$CurrentInstance = $price_finder;
	}

	/**
	 * 
	 *
	 *	$price = $price_finder->getPrice($product);
	 *	$price = $price_finder->getPrice($product,10);
	 */
	function getPrice($product,$amount = null,$options = []){
		$options += [
			"return_null_when_price_does_not_exist" => true,
		];

		if(is_null($amount)){
			$amount = $product->getUnit()->getMinimumQuantityToOrder(); // 1ks nebo 10cm
		}

		$data = $this->_getPriceData($product);

		$price = new ProductPrice($data,$amount,$this->currency,$this->current_date,$this);
		if($options["return_null_when_price_does_not_exist"] && !$price->priceExists()){
			return null;
		}
		return $price;
	}

	function getBasePrice($product,$amount = null,$options = []){
		$options += [
			"return_null_when_price_does_not_exist" => true,
		];

		if(is_null($amount)){
			$amount = $product->getUnit()->getMinimumQuantityToOrder(); // 1ks nebo 10cm
		}

		$data = $this->_getPriceData($product);
		$prices = [];
		foreach($data["prices"] as $price_item){
			if($price_item["is_base_price"]){
				$prices[] = $price_item;
			}
			$data["prices"] = $prices;
		}

		$price = new ProductPrice($data,$amount,$this->currency,$this->current_date,$this);
		if($price->priceExists()){
			$_price = $this->getPrice($product,$amount,$options);
			if($price->getUnitPrice()<=$_price->getUnitPrice()){
				$data["prices"] = [];
				$price = new ProductPrice($data,$amount,$this->currency,$this->current_date,$this); // Base price not exists
			}
		}

		if($options["return_null_when_price_does_not_exist"] && !$price->priceExists()){
			return null;
		}
		return $price;
	}

	/**
	 * Returns all distinct prices from all products on this card
	 *
	 * return ProductPrice[]
	 */
	function getDistinctPrices($card){
		$prices = [];
		foreach($card->getProducts() as $product){
			$price = $this->getPrice($product);
			if(!$price){ continue; }
			$key = (string)round($price->getUnitPrice(),4);
			$prices[$key] = $price;
		}
		return array_values($prices);
	}

	/**
	 * Searches for the lowest price of a product on this card
	 *
	 *	$product_price = $price_finder->getStartingPrice($card);
	 *
	 * @return ProductPrice
	 */
	function getStartingPrice($card){
		list($starting_price,$starting_base_price) = $this->_getStartingPrice($card);
		return $starting_price;
	}

	/**
	 * Searches for the lowest base price of a product on this card
	 *
	 *	$product_price = $price_finder->getStartingBasePrice($card);
	 *
	 * @return ProductPrice
	 */
	function getStartingBasePrice($card){
		list($starting_price,$starting_base_price) = $this->_getStartingPrice($card);
		return $starting_base_price;
	}

	function _getStartingPrice($card){
		$lowest_unit_price = null;
		$starting_price = $starting_base_price = null;
		foreach($card->getProducts() as $product){
			$price = $this->getPrice($product);
			if(!$price){ continue; }
			if(is_null($lowest_unit_price) || $lowest_unit_price>$price->getUnitPrice()){
				$starting_price = $price;
				$starting_base_price = $this->getBasePrice($product);
				$lowest_unit_price = $price->getUnitPrice();
			}
		}
		return [$starting_price,$starting_base_price];
	}

	function getUser(){ return $this->user; }

	function getCurrency(){ return $this->currency; }

	protected function _getPricelist(){
		return Pricelist::GetDefaultPricelist();
	}

	protected function _getPriceData($product, $options=[]){
		return $this->priceData->get($product, $options);
	}

	function getPriceDataFor($ids, $options) {
		$pricelists = [$this->pricelist->getId()];
		if($this->base_pricelist){ $pricelists[] = $this->base_pricelist->getId(); }
		// TODO: The sorting must respect if one price list contains prices with VAT and the second one doesn't
		$rows = $this->dbmole->selectRows("SELECT
					product_id,
					MIN(price) AS price,
					minimum_quantity,
					pricelist_id
				FROM pricelist_items
				WHERE
					pricelist_id IN :pricelists AND
					product_id IN :product AND
					(valid_from IS NULL OR valid_from<=:now) AND
					(valid_to IS NULL OR valid_to>=:now)
				GROUP BY product_id,minimum_quantity,pricelist_id
				ORDER BY
					product_id,
					minimum_quantity,
					MIN(price),
					pricelist_id=:pricelist_id DESC -- the main price list takes precedence
			",[
				":product" => $ids,
				":pricelists" => $pricelists,
				":pricelist_id" => $this->pricelist->getId(),
				":now" => $this->current_date,
			]
		);
		$products = Cache::Get('Product', array_combine($ids, $ids));
		$prices = [];
		foreach($rows as $row) {
			$product = Cache::Get("Product",$row["product_id"]);
			$row["price"] = (float)$row["price"];
			$row["is_base_price"] = $this->base_pricelist && $this->base_pricelist->getId()==$row["pricelist_id"];

			$pricelist = $row["is_base_price"] ? $this->base_pricelist : $this->pricelist;

			if($pricelist->containsPricesWithoutVat()){
				$row["price_incl_vat"] = $this->_addVat($row["price"],$product->getVatPercent());
			}else{
				$row["price_incl_vat"] = $row["price"];
				$row["price"] = $this->_removeVat($row["price"],$product->getVatPercent());
			}
			$p_id = $row["product_id"];
			if(!isset($prices[$p_id])){ $prices[$p_id] = []; }
			$prices[$p_id][] = $row;
		}

		$discounts = Discount::GetDiscountDataForProduct($ids);

		$out = [];
		foreach($ids as $id) {
			$discount = $discounts[$id];
			$out[$id] = [
				"product_id" => $id,
				"vat_percent" => $products[$id] ? $products[$id]->getVatPercent() : null,
				"discount_percent" => $discount?$discount['discount_percent']:null,
				"discounted_from" => $discount?$discount['discounted_from']:null,
				"discounted_to" => $discount?$discount['discounted_to']:null,
				"prices" => isset($prices[$id]) ? $prices[$id] : []
			];
		}
		return $out;
	}
}
