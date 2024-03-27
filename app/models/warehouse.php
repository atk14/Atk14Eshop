<?php
class Warehouse extends ApplicationModel implements Translatable, Rankable {

	use TraitCodebook;

	static function GetTranslatableFields(){ return array("name"); }

	function setRank($rank){
		$this->_setRank($rank);
	}

	static function GetDefaultInstance4Eshop($options = []){
		static $instance;

		$options += [
			"flush_cache" => false,
		];

		if(!$instance || $options["flush_cache"]){
			$instance = self::FindFirst("applicable_to_eshop",true,["use_cache" => true]);
		}
		return $instance;
	}

	function applicableToEshop(){
		return $this->g("applicable_to_eshop");
	}

	function getProductStockcount($product){
		$stockcount = $this->dbmole->selectInt("SELECT stockcount FROM warehouse_items WHERE warehouse_id=:warehouse AND product_id=:product",[":warehouse" => $this, ":product" => $product]);
		if(is_null($stockcount)){ $stockcount = 0; }
		return $stockcount;
	}

	/**
	 *
	 *	$warehouse->addProduct($product,100);
	 *	$warehouse->addProduct($product,-10);
	 */
	function addProduct($product,$stockcount){
		$product = is_object($product) ? $product->getId() : $product;
		if(is_null($product)){ return; }
		$product = (int)$product;

		$stockcount = (int)$stockcount;

		if($stockcount===0){
			return;
		}

		$price_rounding = Product::GetInstanceByCode("price_rounding");
		if($price_rounding && $product===$price_rounding->getId()){
			return;
		}

		$bind_ar = [
			":warehouse_id" => $this,
			":product_id" => $product,
			":stockcount" => $stockcount,
		];

		$update_sql = "UPDATE warehouse_items SET stockcount = stockcount + :stockcount WHERE warehouse_id = :warehouse_id AND product_id = :product_id ";
		$sql = "DO $$ BEGIN
			WITH updated AS ($update_sql RETURNING id)
			INSERT INTO warehouse_items(id, warehouse_id, product_id, stockcount)
				 SELECT NEXTVAL('seq_warehouse_items'), :warehouse_id, :product_id, :stockcount
				 WHERE (SELECT COUNT(*) FROM updated) = 0;
			EXCEPTION WHEN unique_violation THEN
			   $update_sql;
			END $$;
		";
		$this->dbmole->doQuery($sql, $bind_ar);
	}

	function toString(){
		return (string)$this->getName();
	}

	function isDeletable(){
		return true;
	}
}
