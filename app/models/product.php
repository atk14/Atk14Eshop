<?php
class Product extends ApplicationModel implements Translatable,Rankable{
	
	static function GetTranslatableFields(){ return array("name", "shortinfo", "action_info"); }

	static function GetInstanceByCatalogId($catalog_id){
		($product = Product::FindByCatalogId($catalog_id,array("use_cache" => true))) ||
		($product = Product::FindFirst(array(
			"conditions" => "deleted='t' AND catalog_id LIKE :catalog_id||'~%'",
			"bind_ar" => array(":catalog_id" => $catalog_id),
			"use_cache" => true
		)));
		return $product;
	}

	function getName($lang = null){
		$card = $this->getCard();
		if(!$card->hasVariants()){ return $card->getName($lang); }
		return parent::getName($lang);
	}

	function getShortinfo($lang = null){
		$card = $this->getCard();
		if(!$card->hasVariants()){ return $card->getTeaser($lang); }
		return parent::getShortinfo($lang);
	}

	function getCard(){ return Cache::Get("Card",$this->getCardId()); }

	function getVatRate(){ return Cache::Get("VatRate",$this->getVatRateId()); }
	function getVatPercent(){ return $this->getVatRate()->getVatPercent(); }

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

	function getImage(){
		if($images = $this->getImages()){
			return $images[0];
		}

		$card = $this->getCard();
		if($images = $card->getImages(array("consider_product_images" => false))){
			return $images[0];
		}
	}

	function setRank($new_rank){
		return $this->_setRank($new_rank,array(
			"card_id" => $this->getCardId(),
			"deleted" => false,
		));
	}

	function isDeleted(){ return $this->getDeleted(); }
	function isVisible(){ return $this->getVisible(); }
	function assemblyIsAvailable() {
		return $this->getAssembly()==true;
	}
	function assemblyCanBeOrdered() {
		return $this->assemblyIsAvailable();
	}

	function destroy($delete_for_real = false){
		if($delete_for_real){
			return parent::destroy($delete_for_real);
		}

		if($this->isDeleted()){
			return null;
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

	function isOnlyForIndividualTransport() {
		return $this->getIndividualTransport();
	}

	function isNewItem() {
		return $this->getNewItem()==true;
	}

	function getBannedShippings() {
		$types = preg_split("/[\s,]/", $this->g("banned_shipping"), -1, PREG_SPLIT_NO_EMPTY);
		return $types;
	}

	/**
	 * Produkt neni standardne na sklade. Lze objednat na zavolani
	 */
	function isAvailableOnRequest() {
		return $this->getAvailableOnRequest()==true;
	}

	function isClubItem() {
		return $this->getIsClubItem()==true;
	}

	function getStockcount(){
		return $this->dbmole->selectInt("SELECT SUM(warehouse_items.stockcount) FROM warehouses,warehouse_items WHERE warehouses.applicable_to_eshop AND warehouse_items.warehouse_id=warehouses.id AND warehouse_items.product_id=:product",[":product" => $this]);
	}

	/**
	 * TODO: asi by se to jeste mohlo otestovat na viditelnost.
	 */
	function canBeOrdered() {
		$c = $this->getCard();
		return (
			$this->isVisible() && !$this->isDeleted() && ($this->getStockcount()>0 || $this->isAvailableOnRequest()) &&
			$c->isVisible() && !$c->isDeleted()
		);
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
	function getCalculatedMaximumQuantityToOrder(){
		$max = $this->getMaximumQuantityToOrder();

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
	function getMaximumQuantityToOrder(){
		if(!$this->getConsiderStockcount()){
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

	function toHumanReadableString(){
		$out = $this->getCatalogId();
		$out .= ", ".$this->getName();
		return $out;
	}
}
