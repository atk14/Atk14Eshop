<?php
class FavouriteProductsController extends ApplicationController {

	function index(){
		$this->page_title = $this->breadcrumbs[] = _("Oblíbené produkty");
		$this->tpl_data["favourite_products"] = $this->favourite_products_accessor->getFavouriteProducts();
	}

	function create_new(){
		if(!$this->request->post()){
			return $this->_redirect_back();
		}

		if(!($product = $this->_find("product","product_id"))){
			return;
		}

		$this->favourite_products_accessor->addProduct($product);

		if(!$this->request->xhr()){
			$this->_redirect_back();
		}
	}

	function destroy(){
		if(!$this->request->post()){
			return $this->_redirect_back();
		}

		if(!($product = $this->_find("product","product_id"))){
			return;
		}
		
		$this->favourite_products_accessor->delProduct($product);

		if(!$this->request->xhr()){
			$this->_redirect_back();
		}
	}
}
