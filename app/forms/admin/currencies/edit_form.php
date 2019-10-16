<?php
class EditForm extends CurrenciesForm {
	
	function set_up(){
		parent::set_up();
		$this->fields["code"]->disabled = true;

		if($this->controller->currency->isDefaultCurrency()){
			$this->fields["rate"]->disabled = true;
			$this->fields["rate"]->help_text = _("Conversion rate cannot be changed on the default currency");
		}
	}
}
