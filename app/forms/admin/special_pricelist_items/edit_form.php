<?php
class EditForm extends SpecialPricelistItemsForm {

	function set_up(){
		parent::set_up();
		$this->fields["product_id"]->disabled = true;
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && ($spi = $this->_get_conflicting_record($d)) && $spi->getId()!=$this->controller->special_pricelist_item->getId()){
			$this->set_error(_("Stejná kombinace produktu a minimálního množství již existuje"));
		}
			
		return [$err,$d];
	}
}
