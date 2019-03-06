<?php
class Pricelist extends ApplicationModel {
	const ID_DEFAULT = 1;

	static function GetDefaultPricelist(){
		return Cache::Get("Pricelist",self::ID_DEFAULT);
	}

	/**
	 *	$prices = [
	 *		$product_1->getId() => 123.00,
	 *		$product_2->getId() => 10.20,
	 *		// ...
	 *	];
	 *	$pricelist->setPrices($prices);
	 */
	function setPrices($prices,$options = []){
		$options += [
			"delete_missing_prices" => true,
		];

		$existing = $this->dbmole->selectIntoAssociativeArray("SELECT product_id,price FROM pricelist_items WHERE pricelist_id=:this",[":this" => $this]);
		foreach($prices as $product_id => $price){
			$price = number_format($price,'4','.','');
			$existing_price = isset($existing[$product_id]) ? number_format($existing[$product_id],'4','.','') : null;
			if(!isset($existing_price)){
				PricelistItem::CreateNewRecord([
					"pricelist_id" => $this,
					"product_id" => $product_id,
					"price" => $price,
				]);
				continue;
			}
			if($existing_price!==$price){
				$pi = PricelistItem::FindFirst("pricelist_id",$this,"product_id",$product_id);
				$pi->s("price",$price);
			}
			unset($existing[$product_id]);
		}

		if($options["delete_missing_prices"] && $existing){
			$this->dbmole->doQuery("DELETE FROM pricelist_items WHERE pricelist_id=:this AND product_id IN :p",[":this" => $this, ":p" => array_keys($existing)]);
		}
	}

	function setPrice($product_id, $price) {
		$product_id = TableRecord::ObjToId($product_id);
		return $this->setPrices([$product_id => $price], ["delete_missing_prices" => false]);
	}

	function getCurrency(){
		return Currency::GetDefaultCurrency();
	}
}
