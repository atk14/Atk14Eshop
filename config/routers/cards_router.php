<?php
/**
 * Z {link_to controller="pages" action="detail" id="4"}
 * udela
 * /zvitezili-jsme-v-soutezi-prodejna-roku-2012/
 */
class CardsRouter extends SluggishRouter{

	function recognize($uri){
		global $ATK14_GLOBAL;

		if(!preg_match('/^\/(?P<type>[a-z0-9-]+)\/(?P<card>[a-z0-9-]+)(|\/(?P<product>[a-z0-9-]+))\/?$/',$uri,$matches)){
			return;
		}

		$type_slygs = array();
		foreach(ProductType::FindAll(array("use_cache" => true)) as $pt){
			foreach($ATK14_GLOBAL->getSupportedLangs() as $l){
				$s = $pt->getSlug($l);
				if(!isset($type_slygs[$s])){ $type_slygs[$s] = array(); }
				$type_slygs[$s][] = $l;
			}
		}

		if(!isset($type_slygs[$matches["type"]])){
			return;
		}

		foreach($type_slygs[$matches["type"]] as $l){
			$card = Card::GetInstanceBySlug($matches["card"],$l);
			if(!$card){ continue; }

			$product = null;
			if(isset($matches["product"])){
				$product = Product::GetInstanceBySlug($matches["product"],$l,(string)$card->getId());
				if(!$product){
					continue;
				}
			}

			$this->controller = "cards";
			$this->action = "detail";
			$this->params["id"] = $card->getId();
			if($product){
				$this->params["product_id"] = $product->getId();
			}
			$this->lang = $l;
			return;
		}
	}

	function build(){
		$lang = (string)$this->lang;
		$action = (string)$this->action;

		if($this->controller!="cards" || $this->action!="detail" || !$this->params->defined("id")){ return; }

		$card = Cache::Get("Card",$this->params->getInt("id"));
		if(!$card){ return; }

		$product = null;
		if($this->params->defined("product_id")){
			$product = Cache::Get("Product",$this->params->getInt("product_id"));
			if(!$product){ return; }
		}

		$this->params->del("id");
		$this->params->del("product_id");

		$product_type = $card->getProductType();

		return '/'.$product_type->getSlug($lang).'/'.$card->getSlug($lang).'/' . ($product ? $product->getSlug($lang,(string)$card->getId()).'/' : '');
	}
}
