<?php
class GetVoucherTypeForm extends VouchersForm {

	function set_up(){
		$this->add_field("voucher_type", new ChoiceField([
			"label" => _("Vyberte typ poukazu"),
			"widget" => new RadioSelect(),
			"choices" => [
				"gift_card" => _("dárkový (zakoupený) poukaz"),
				"discount_voucher" => _("slevový poukaz"),
			],
		]));

		$this->set_button_text(_("Pokračovat"));
	}
}
