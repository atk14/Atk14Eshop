<?php
class CreateNewForm extends SpecialPricelistItemsForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && $this->_get_conflicting_record($d)){
			$this->set_error("product_id",_("Záznam pro tento produkt již v ceníku existuje"));
		}

		return [$err,$d];
	}
}
