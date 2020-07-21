<?php
class CreateNewForm extends WarehouseItemsForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && $this->_get_conflicting_record($d)){
			$this->set_error(_("Záznam o skladové zásobě tohoto produktu již existuje"));
		}

		return [$err,$d];
	}
}
