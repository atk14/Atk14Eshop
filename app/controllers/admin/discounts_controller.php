<?php
class DiscountsController extends AdminController {

	function index(){
		$this->sorting->add("created_at","created_at DESC, id DESC","created_at ASC, id ASC");
		$this->sorting->add("discount_percent","discount_percent DESC, created_at DESC, id DESC","discount_percent ASC, created_at ASC, id ASC");

		$conditions = $bind_ar = [];

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());
		if ($d["products_in_shop"]) {
			$conditions[] = "product_id IN (SELECT products.id from products,prepared_cards WHERE products.card_id=prepared_cards.id)";
		}
		if ($d["holder"]) { // "product", "category"
			$conditions[] = "$d[holder]_id IS NOT NULL";
		}

		$this->_index([
			"page_title" => _("Seznam slev"),
			"conditions" => $conditions,
		]);
	}
	
	function create_new(){
		$this->_create_new();
	}

	function edit(){
		$this->_edit();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filder(){
		if(in_array($this->action,"edit")){
			$this->_find("discount"); // Potrebujeme $this->discount ve EditForm
		}
	}
}
