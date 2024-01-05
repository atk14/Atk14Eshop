<?php
class SetBillingAndDeliveryDataForm extends CheckoutsForm {

	function set_up(){
		$delivery_address_editable_by_user = $this->controller->basket->deliveryAddressEditableByUser();

		// dorucovaci adresa
		$this->_add_firstname_lastname(["prefix" => "delivery_", "required" => true]);
		$this->_add_company_fields(["prefix" => "delivery_", "add_company_number" => false, "add_vat_id" => false, "disabled" => !$delivery_address_editable_by_user]);
		$this->_add_address_fields(["prefix" => "delivery_", "required" => true, "only_allowed_countries_for_delivery" => true, "disabled" => !$delivery_address_editable_by_user]);
		$this->_add_phone(["prefix" => "delivery_"]);

		// fakturacni adresa
		$this->_add_firstname_lastname(["required" => false]);
		$this->_add_email();
		$this->_add_company_fields(["enable_vat_id_validation" => true]);
		$this->_add_address_fields(["required" => false, "add_note" => false, "only_allowed_countries_for_invoice" => true]);

		$this->add_field("fill_in_invoice_address",new BooleanField([
			"label" => _("Chci zadat fakturační údaje"),
			//"help_text" => _("nepovinné"),
			"required" => false,

			"initial" => !$delivery_address_editable_by_user,
			"disabled" => !$delivery_address_editable_by_user,
		]));

		$this->set_button_text(_("Pokračovat"));
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = array_keys($d);

		if(!$this->has_errors()){
			$fields_filled = 0;
			$empty_required_fields = 0;

			$address_fields = Basket::GetAddressFields(["company_data" => true, "address_street2" => false]);

			if(!ALLOW_STATE_IN_ADDRESS){
				$d["delivery_address_state"] = null;
				$d["address_state"] = null;
			}

			foreach($address_fields as $key => $required){
				if("$d[$key]"===""){
					if($required){
						$empty_required_fields++;
					}
					continue;
				}
				$fields_filled++;
			}

			// Pokud je z adresy zadana pouze zeme, tak se ji tady v tichosti zbavime
			if($fields_filled==1 && $d["address_country"]){
				$fields_filled = 0;
				unset($d["address_country"]);
			}

			if($fields_filled>0 && $empty_required_fields>0){
				$this->set_error(_("Vyplňte všechny důležité údaje fakturační adresy"));
			}
		}

		unset($d["fill_in_invoice_address"]);

		$this->_clean_vat_id_and_country();

		return [$err,$d];
	}
}
