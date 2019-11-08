<?php
class IndexForm extends OrdersForm{

	function set_up(){
		$this->add_field("search",new SearchField(array(
			"label" => _("Search"),
			"required" => false,
		)));

		$this->add_field("date_from",new DateField(array(
			"label" => _("Datum od"),
			"required" => false,
			"widget" => new DateInput(array(
				"attrs" => array("class" => "text form-control calendar_field"),
			)),
		)));

		$this->add_field("date_to",new DateField(array(
			"label" => _("Datum od"),
			"required" => false,
			"widget" => new DateInput(array(
				"attrs" => array("class" => "text form-control calendar_field"),
			)),
		)));

		$this->add_field("payment_method_id", new PaymentMethodField([
			"label" => _("Způsob platby"),
			"required" => false,
			"empty_choice_text" => "-- "._("způsob platby")." --",
		]));

		$_statusChoicesAr = [
			"" => "-- "._("stav online platby")." --",
		];
		foreach(PaymentStatus::FindAll() as $ps) {
			$_statusChoicesAr[$ps->getId()] = $ps->getName();
		}
		$this->add_field("payment_status_id", new ChoiceField([
			"label" => _("Stav platby"),
			"required" => false,
			"choices" => $_statusChoicesAr,
		]));

		$this->add_field("delivery_method_id", new DeliveryMethodField([
			"label" => _("Způsob doručení"),
			"required" => false,
			"empty_choice_text" => "-- "._("způsob doručení")." --",
		]));

		$this->add_field("order_status_id", new OrderStatusField(array(
			"label" => _("Stav objednávky"),
			"required" => false,
		)));

		$f = $this->add_field("catalog_id", new CharField(array(
			"label" => _("Objednaný produkt"),
			"required" => false,
		)));
		$f->widget->attrs["placeholder"] = _("Catalog number");
	}
}
