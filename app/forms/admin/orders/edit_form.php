<?php
class EditForm extends OrdersForm {

	function set_up(){
		// fakturacni adresa
		$this->_add_firstname_lastname(["required" => true]);
		$this->_add_email();
		$this->_add_company_fields();
		$this->_add_address_fields(["required" => true, "add_note" => true, "add_address_street2" => true, "add_address_state" => true]);

		// dorucovaci adresa
		$this->_add_firstname_lastname(["prefix" => "delivery_", "required" => true]);
		$this->_add_company_fields(["prefix" => "delivery_", "add_company_number" => false, "add_vat_id" => false]);
		$this->_add_address_fields(["prefix" => "delivery_", "required" => true, "only_allowed_countries_for_delivery" => false, "add_address_street2" => true, "add_address_state" => true]);
		$this->_add_phone(["prefix" => "delivery_"]);

		$this->_add_phone(["required" => false]);

		$this->add_field("delivery_method_id",new DeliveryMethodField([
			"label" => _("Způsob dopravy"),
		]));
		$this->_add_price_field("delivery_fee_incl_vat",["label" => _("Poplatek za dopravu včetně DPH"), "required" => false]);
		$this->add_field("delivery_fee_vat_percent", new VatPercentField([
			"label" => _("Sazba DPH za dopravu"),
		]));

		$this->add_field("payment_method_id",new PaymentMethodField([
			"label" => _("Způsob platby"),
		]));
		$this->_add_price_field("payment_fee_incl_vat",_("Poplatek za platbu včetně DPH"));
		$this->add_field("payment_fee_vat_percent", new VatPercentField([
			"label" => _("Sazba DPH za platební metodu"),
		]));

		$currency = $this->controller->order->getCurrency();

		$this->add_field("price_paid", new PriceField([
			"label" => sprintf(_("Celkem uhrazeno [%s]"),$currency),
			"required" => false,
		]));

		$this->add_field("note", new TextField([
			'label' => 'Poznámka k objednávce',
			"required" => false,
			'widget' => new Textarea([
				'attrs' => ['rows' => 3]
			])
		]));

		$this->add_field("tracking_number", new CharField([
			"label" => _("Číslo zásilky pro sledování"),
			"required" => false,
		]));
	}

	function _add_price_field($k,$options = []){
		if(is_string($options)){
			$options = [
				"label" => $options
			];
		}

		$currency = $this->controller->order->getCurrency();
		$options["label"] = $options["label"]." [".$currency."]";

		$this->add_field($k,new PriceField($options));
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = is_array($d) ? array_keys($d) : array(); 

		if(in_array("delivery_fee",$keys) && in_array("delivery_fee_incl_vat",$keys)){
			if(isset($d["delivery_fee"]) && !isset($d["delivery_fee_incl_vat"])){
				$this->set_error("delivery_fee_incl_vat",_("Specify the delivery fee incl. VAT"));
			}
			if(!isset($d["delivery_fee"]) && isset($d["delivery_fee_incl_vat"])){
				$this->set_error("delivery_fee_incl_vat",_("Specify the delivery fee"));
			}
		}

		return [$err,$d];
	}
}
