<?php
class Product extends ApplicationModel implements Translatable,Rankable{

	use TraitGetInstanceByCode;
	use TraitTags;
	
	static function GetTranslatableFields(){
		return array(
			"label", // označení varianty, e.g "XL", "50g", "32GB"
			"name",
			"description",
		);
	}

	static function GetInstanceByCatalogId($catalog_id){
		if(is_null($catalog_id)){ return; }
		$catalog_id = (string)$catalog_id;
		($product = Product::FindByCatalogId($catalog_id,array("use_cache" => true))) ||
		($product = Product::FindFirst(array(
			"conditions" => "deleted='t' AND catalog_id LIKE :catalog_id||'~%'",
			"bind_ar" => array(":catalog_id" => $catalog_id),
			"use_cache" => true
		)));
		return $product;
	}

	static function CreateNewRecord($values,$options = []){
		$values += [
			"vat_rate_id" => VatRate::GetDefaultVatRate(),
		];

		return parent::CreateNewRecord($values,$options);
	}

	function getName($lang = null,$with_label = true){
		if(is_bool($lang)){
			$with_label = $lang;
			$lang = null;
		}

		$name = parent::getName($lang);

		if(strlen((string)$name)>0){
			return $name;
		}

		$card = $this->getCard();
		$name = $card->getName($lang);

		if($with_label){
			if($label = $this->getLabel($lang)){
				$name .= ", ".$label;
			}
		}

		return $name;
	}

	/**
	 *
	 * Alias for ```Product::getName($lang,true);```
	 */
	function getFullName($lang = null){
		return $this->getName($lang,true);
	}

	function getCard(){ return Cache::Get("Card",$this->getCardId()); }

	function getUnit(){ return Cache::Get("Unit",$this->g("unit_id")); }

	function getVatRate(){ return Cache::Get("VatRate",$this->getVatRateId()); }
	function getVatPercent(){
		if($vr = $this->getVatRate()){
			return $vr->getVatPercent();
		}
	}

	function getCatalogId(){
		$catalog_id = $this->g("catalog_id");
		if($this->isDeleted()){
			// 123/456789~deleted-444 -> 123/456789
			$catalog_id = preg_replace('/~deleted-\d+$/','',$catalog_id);
		}
		return $catalog_id;
	}
	
	function getImages(){
		return ProductImage::GetImages($this);
	}

	/**
	 *
	 * $image = $product->getImage(false);
	 */
	function getImage($options = []){
		if(is_bool($options)){
			$options = ["consider_card_image" => $options];
		}
		$options += [
			"consider_card_image" => true,
		];

		if($images = $this->getImages()){
			return $images[0];
		}

		if(!$options["consider_card_image"]){
			return;
		}

		$card = $this->getCard();
		if($images = $card->getImages(array("consider_product_images" => false))){
			return $images[0];
		}
	}

	function containsTag($tag,$options = []){
		$options += [
			"consider_categories" => false,
		];

		$card = $this->getCard();
		if($card->containsTag($tag)){ return true; }
		if($card->hasVariants()){
			if($this->getTagsLister()->contains($tag)){
				return true;
			}
		}
		if($options["consider_categories"]){
			foreach($card->getCategories() as $category){
				if($category->containsTag($tag,["consider_parents" => true])){
					return true;
				}
			}
		}
		return false;
	}

	function setRank($new_rank){
		return $this->_setRank($new_rank,array(
			"card_id" => $this->getCardId(),
			"deleted" => false,
		));
	}

	function isDeletable() {
		return in_array($this->getCode(),array("price_rounding"));
	}

	function isDeleted(){ return $this->getDeleted(); }
	function isVisible(){ return $this->getVisible(); }

	function destroy($delete_for_real = false){
		if($delete_for_real){
			return parent::destroy($delete_for_real);
		}

		if($this->isDeleted()){
			return null;
		}

		foreach(PricelistItem::FindAll("product_id",$this) as $item){
			$item->destroy();
		}

		foreach(WarehouseItem::FindAll("product_id",$this) as $item){
			$item->destroy();
		}

		$this->s(array(
			"deleted" => true,
			"catalog_id" => sprintf("%s~deleted-%s",$this->getCatalogId(),$this->getId()),
		));
	}

	function getSiblings() {
		$products = $this->getCard()->getProducts();
		$_siblings = array();
		foreach($products as $_p) {
			if ($_p->getId()==$this->getId()) {
				continue;
			}
			$_siblings[] = $_p;
		}
		return $_siblings;
	}

	function getSuppliesLister() {
		return $this->getLister("Products", array(
			"table_name" => "supplies",
			"owner_field_name" => "device_product_id",
		));
	}

	/**
	 * Spotrebni material pro tento produkt.
	 *
	 * @return Product
	 */
	function getSupplies() {
		$supplies_lister = $this->getSuppliesLister();
		return $supplies_lister->getRecords();
	}

	function getDevicesLister() {
		return $this->getLister("Products", array(
			"table_name" => "supplies",
			"owner_field_name" => "product_id",
			"subject_field_name" => "device_product_id",
		));
	}

	function getDevices() {
		return $this->getDevicesLister()->getRecords();
	}

	function getCalculatedMinimumQuantityToOrder(){
		return $this->roundQuantityToOrder($this->getMinimumQuantityToOrder());
	}

	/**
	 * Po jakych krocich se da tato latka objednat...
	 */
	function getOrderQuantityStep(){
		$step = $this->getUnit()->getQuantityStep();
		$min = ceil($this->getMinimumQuantityToOrder() / $step) * $step;
		return max($step, $min);
	}

	/**
	 *
	 * Nikdy nevrati null!
	 * Vrati nejake vysoke cislo, pokud neni pocet omezen
	 */
	function getCalculatedMaximumQuantityToOrder($options = []){
		$max = $this->getMaximumQuantityToOrder($options);

		if(is_null($max)){
			$max = 999999;
		}

		$max = $this->roundQuantityToOrder($max, 'floor');

		$min = $this->getCalculatedMinimumQuantityToOrder();
		if($min && $min>$max){
			$max = 0;
		}

		return $max;
	}

	function getCalculatedStandardQuantityToOrder(){
		$INITIAL_FABRIC_LENGTH = 50;
		$out = $this->roundQuantityToOrder($this->getMinimumQuantityToOrder());
		if($this->getUnit()->getUnit()=="cm" && $out<$INITIAL_FABRIC_LENGTH){
			$out = $this->roundQuantityToOrder($INITIAL_FABRIC_LENGTH, 'floor');
			//$out = $INITIAL_FABRIC_LENGTH;
		}
		$max = $this->getCalculatedMaximumQuantityToOrder();
		if($max) {
			$out = min($max, $out);
		}
		$out = max( $this->getCalculatedMinimumQuantityToOrder(), $out);
		return $out;
	}

	function roundQuantityToOrder($quantity, $fce = 'ceil') {
		$step = $this->getOrderQuantityStep();
		return $fce($quantity / $step) * $step;
	}

	function getMinimumQuantityToOrder(){
		if($this->g("minimum_quantity_to_order")){
			return $this->g("minimum_quantity_to_order");
		}
		$unit = $this->getUnit();
		return $unit->getMinimumQuantityToOrder();
	}

	/**
	 *
	 * Implementacni poznamky:
	 *
	 * * null -> lze objednavat bez limitu
	 * * tato funkce nikdy nevrati zaporne cislo
	 * * vracena hodnota NERESPEKTUJE nejmensiho delitele, k tomu je funkce getCalculatedMaximumQuantityToOrder()
	 *
	 */
	function getMaximumQuantityToOrder($options = []){
		$options += [
			"real_quantity" => false, // true - do not care of consider_stockcount
		];

		if(!$this->getConsiderStockcount() && !$options["real_quantity"]){
			// Skladova zasoba se v tomto pripade pri stanoveni max. mnozstvi neuvazuje
			return null;
		}
		$stockcount = $this->getStockcount();
		$hidden_stock_reserva = $this->getHiddenStockReserve();
		$blocation = $this->getStockcountBlocation();

		$out = $stockcount - $hidden_stock_reserva - $blocation;

		return $out>0 ? $out : 0;
	}

	/**
	 * Vrati skrytou skladovou zasobu pro tento produkt
	 *
	 * @return int
	 */
	function getHiddenStockReserve(&$lowest_offered_quantity = null){
		static $CACHE = [];

		$key = (string)$this->getId();

		if(!array_key_exists($key,$CACHE)){
			$ids_to_read = $this->_getIdsToPrereadData(array_keys($CACHE));

			foreach($ids_to_read as $id){
				$CACHE["$id"] = ["reserve" => 0, "lowest_offered_quantity" => 0];
			}

			$query = "
				SELECT product_id, reserve, lowest_offered_quantity FROM (
				SELECT
					product_id,
					reserve,
					lowest_offered_quantity,
					-1 AS distance
				FROM
					hidden_stock_reserves
				WHERE
					product_id IN :products
				--
				UNION
				SELECT
					products.id,
					hidden_stock_reserves.reserve,
					hidden_stock_reserves.lowest_offered_quantity,
					v_card_categories.distance AS distance
				FROM
					products,
					mv_card_categories AS v_card_categories,
					hidden_stock_reserves
				WHERE
					products.id IN :products AND
					v_card_categories.card_id=products.card_id AND
					hidden_stock_reserves.category_id=v_card_categories.category_id AND
					hidden_stock_reserves.unit_id=products.unit_id
				)q ORDER BY distance DESC
			";
			$bind_ar = [
				":products" => $ids_to_read,
			];
			$rows = $this->dbmole->selectRows($query,$bind_ar);

			foreach($rows as $row){
				// zaznam s mensim distance prepise pripadny predchozi zaznam
				$CACHE[$row["product_id"]] = [
					"reserve" => (int)$row["reserve"],
					"lowest_offered_quantity" => (int)$row["lowest_offered_quantity"],
				];
			}
		}

		$lowest_offered_quantity = $CACHE[$key]["lowest_offered_quantity"];
		return $CACHE[$key]["reserve"];
	}

	static protected $Stockcounts;

	/**
	 *
	 *	$stockcount_1 = $product->getStockcount();
	 *	$stockcount_2 = $product->getStockcount($warehouse);
	 *	$stockcount_3 = $product->getStockcount([$warehouse1,$warehouse2]);
	 */
	function getStockcount($warehouses = null){
		if(!is_null($warehouses)){
			$warehouses = is_array($warehouses) ? $warehouses : [$warehouses];
			$warehouses = array_filter($warehouses);
			if(!$warehouses){ return 0; } // []
			return $this->dbmole->selectInt("SELECT COALESCE(SUM(stockcount),0) FROM warehouse_items WHERE product_id=:product AND warehouse_id IN :warehouses",[":product" => $this, ":warehouses" => $warehouses]);
		}
		if(!self::$Stockcounts) {
			self::$Stockcounts = new CacheSomething(function($ids) {
				return Product::GetDbMole()->selectIntoAssociativeArray("SELECT warehouse_items.product_id, SUM(warehouse_items.stockcount) FROM warehouses,warehouse_items WHERE warehouses.applicable_to_eshop AND warehouse_items.warehouse_id=warehouses.id AND warehouse_items.product_id IN :ids GROUP BY warehouse_items.product_id", [':ids' => $ids]);
			}, 'Product');
		};
		return (int) self::$Stockcounts->get($this->getId());
	}

	function getStockcountBlocation(){
		static $CACHE = [];

		$key = (string)$this->getId();

		if(!array_key_exists($key,$CACHE)){
			$ids_to_read = $this->_getIdsToPrereadData(array_keys($CACHE));

			foreach($ids_to_read as $id){
				$CACHE["$id"] = 0;
			}

			$query = "
				SELECT
					product_id,
					SUM(stockcount) AS stockcount
				FROM
					v_stockcount_blocations
				WHERE
					product_id IN :products
				GROUP BY product_id
			";
			$bind_ar = [
				":products" => $ids_to_read,
			];
			$rows = $this->dbmole->selectRows($query,$bind_ar);

			foreach($rows as $row){
				$CACHE[$row["product_id"]] = (int)$row["stockcount"];
			}
		}

		return $CACHE[$key];
	}

	/**
	 * Uvazuje se u tohoto produktu skladova zasoba?
	 */
	function considerStockcount(){
		return $this->g("consider_stockcount");
	}

	/**
	 * Uvazuji se u tohoto produktu pripadne mnozstevni slevy?
	 *
	 * Je lhostejno zda produkt mnozstevni slevy v ceniku ma nebo nema.
	 */
	function quantityDiscountsEnabled(){
		if(!$this->considerStockcount()){
			return true;
		}

		$unit = $this->getUnit();
		return $this->getStockcount()>=$unit->getMinimumStockcountForQuantityDiscounts();
	}

	/**
	 * Can a campaign or voucher discount be applied on this product?
	 *
	 */
	function invoiceDiscountAllowed(){
		$card = $this->getCard();
		$product_type = $card->getProductType();
		return $product_type->invoiceDiscountAllowed();
	}

	/**
	 * Can be this product ordered?
	 *
	 *	$produkt->canBeOrdered();
	 *	$product->canBeOrdered(["amount" => 10]); // Can be 10 pcs of this product ordered?
	 *	$product->canBeOrdered(["amount" => 10, "price_finder" => $price_finder]);
	 *	$produkt->canBeOrdered($price_finder);
	 */
	function canBeOrdered($options = []) {
		if(is_a($options,"PriceFinder")){
			$options = ["price_finder" => $options]; 
		}

		if(is_null($options)){
			$options = [];
		}

		$options += [
			"amount" => null,
			"price_finder" => null,
		];

		if(is_null($options["price_finder"])){
			$options["price_finder"] = PriceFinder::GetInstance();
		}

		$amount = $options["amount"];
		$price_finder = $options["price_finder"];

		$card = $this->getCard();

		if(
			!$this->isVisible() || $this->isDeleted() ||
			!$card->isVisible() || $card->isDeleted()
		){
			return false;
		}

		$max = $this->getCalculatedMaximumQuantityToOrder();
		$min = $this->getCalculatedMinimumQuantityToOrder();

		if(isset($amount)){
			if($amount<$min){ return false; }
			if(isset($max) && $amount>$max){ return false; }
		}

		if($price_finder && !$price_finder->getPrice($this)){
			return false;
		}

		if(is_null($max)){
			return true;
		}

		if($max<=0){
			return false;
		}

		if($max && $max < $min) {
			return false;
		}

		return true;
	}

	function toHumanReadableString(){
		$out = $this->getCatalogId();
		$out .= ", ".$this->toString();
		return $out;
	}

	function toString(){
		return $this->getFullName();
	}

	protected function _getIdsToPrereadData($already_read_ids = []){
		$out = [$this->getId()];
		foreach(Cache::CachedIds(get_class($this)) as $id){
			if($id == $this->getId()){ continue; }
			if(in_array($id,$already_read_ids)){ continue; }
			$out[] = $id;
			if(sizeof($out)>=TABLERECORD_MAX_NUMBER_OF_RECORDS_READ_AT_ONCE){ return $out; }
		}
		return $out;
	}
}
