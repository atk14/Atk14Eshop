<?php
class EditForm extends PricelistItemsForm {

	function set_up(){
		parent::set_up();
		$this->fields["product_id"]->disabled = true;
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && ($pi = $this->_get_conflicting_record($d)) && $pi->getId()!=$this->controller->pricelist_item->getId()){
			$this->set_error(_("Stejná kombinace produktu, ceny a minimálního množství již existuje"));
		}
			
		return [$err,$d];
	}
}
