<?php
class EditForm extends DiscountsForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["category_id"]) && ($disc = Discount::FindFirst("category_id",$d["category_id"]))){
			if($disc->getId()!=$this->controller->discount->getId()){
				$this->set_error("category_id",_("Jiná sleva je již pro tuto kategorii nastavena"));
			}
		}

		if(isset($d["product_id"]) && ($disc = Discount::FindFirst("product_id",$d["product_id"]))){
			if($disc->getId()!=$this->controller->discount->getId()){
				$this->set_error("product_id",_("Jiná sleva je již pro tento produkt nastavena"));
			}
		}

		return [$err,$d];
	}
}
