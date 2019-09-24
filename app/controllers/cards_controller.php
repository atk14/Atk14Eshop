<?php
class CardsController extends ApplicationController{

	function detail(){
		$card = $this->card;

		if(!$card->isViewableInEshop()){
			return $this->_execute_action("error404");
		}

		if(!$card->isVisible() || $card->isDeleted()){
			$this->response->setStatusCode("404");
		}

		$this->page_title = $card->getName();

		$this->tpl_data["products"] = $products = $card->getProducts();
		$this->tpl_data["categories"] = $card->getCategories(array("consider_invisible_categories" => false, "consider_filters" => false));
		$this->tpl_data["starting_price"] = $this->price_finder->getStartingPrice($card);

		$primary_category = $card->getPrimaryCategory();
		if($primary_category){
			foreach($primary_category->getPathOfCategories() as $c){
				$this->breadcrumbs[] = array($c->getName(),$this->_link_to(array("action" => "categories/detail", "path" => $c->getPath())));
			}
		}
		$this->breadcrumbs[] = $card->getName();

		// Urceni typu obrazkove galerie: normal nebo with_variants
		// - with_variants: produkt ma varianty, ktere maji alespon 2 sve obrazky
		// - normal: vsechny jine pripady
		$products = $card->getProducts();
		$gallery_variant = "normal";
		if(sizeof($products)>1){
			$images = array_map(function($product){ return $product->getImage(false); },$products);
			$images = array_filter($images);
			if(sizeof($images)>1){
				$gallery_variant = "with_variants";
			}
		}
		$this->tpl_data["gallery_variant"] = $gallery_variant;
	}

	function _before_filter(){
		$this->_find("card");
	}
}
