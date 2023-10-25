<?php
use StructuredData\Element\BreadcrumbList;
use StructuredData\Element\Product;

class CardsController extends ApplicationController{

	function detail(){
		$card = $this->card;

		if(!$card->isViewableInEshop()){
			return $this->_execute_action("error404");
		}

		if($card->isDeleted() || !$card->isVisible()){
			// In case of a deleted or invisible product, the HTTP 404 Not Found status is set but the product is displayed on the page.
			$this->response->setStatusCode("404");
		}

		$this->page_title = $card->getPageTitle();
		$this->page_description = $card->getPageDescription();

		$this->tpl_data["products"] = $products = $card->getProducts();
		$this->tpl_data["categories"] = $card->getCategories(array("consider_invisible_categories" => false, "consider_filters" => false, "deduplicate" => true));
		$this->tpl_data["starting_price"] = $this->price_finder->getStartingPrice($card);
		$this->tpl_data["main_creators"] = CardCreator::GetMainCreatorsForCard($card);

		$this->_add_card_to_breadcrumbs($card);
		$bclist = new BreadcrumbList($card->getPrimaryCategory(), ["add_parent_elements" => true]);
		$bclist->addListItem($card);
		$this->structured_data->addItem($bclist);
		if(!($card->isDeleted() || !$card->isVisible())){
			$this->structured_data->addItem(new Product($card, ["price_finder" => $this->price_finder, "basket" => $this->basket]));
		}

		// Urceni typu obrazkove galerie: normal nebo with_variants
		// - with_variants: produkt ma varianty, ktere maji alespon 2 sve obrazky
		// - normal: vsechny jine pripady
		$products = $card->getProducts();
		$gallery_variant = "normal";
		if(sizeof($products)>1){
			$images = array_map(function($product){ return $product->getImage(false); },$products);
			$images = array_filter($images);
			if(sizeof($images)>0){
				$gallery_variant = "with_variants";
			}
		}
		$this->tpl_data["gallery_variant"] = $gallery_variant;
		$this->head_tags->setCanonical(Atk14Url::BuildLink(["controller" => $this->controller, "action" => $this->action, "id" => $this->card], ["with_hostname" => true]));
	}

	function _before_filter(){
		$this->_find("card");
	}
}
