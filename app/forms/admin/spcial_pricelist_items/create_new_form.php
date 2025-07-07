<?php
class CreateNewForm extends PricelistItemsForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && $this->_get_conflicting_record($d)){
			$this->set_error(_("Stejná kombinace produktu, ceny a minimálního množství již existuje"));
		}

		return [$err,$d];
	}
}
