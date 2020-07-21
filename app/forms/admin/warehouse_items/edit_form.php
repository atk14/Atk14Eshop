<?php
class EditForm extends WarehouseItemsForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && $this->_get_conflicting_record($d)){
			$this->set_error(_("Záznam o skladové zásobě tohoto produktu již existuje"));
		}

		return [$err,$d];
	}

	function _get_conflicting_record($d){
		$record = parent::_get_conflicting_record($d);
		if($record && $record->getId()===$this->controller->warehouse_item->getId()){
			$record = null;
		}
		return $record;
	}
}
