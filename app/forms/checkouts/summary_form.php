<?php
// Formular pro dokonceni objednavky
class SummaryForm extends CheckoutsForm {

	function set_up(){
		$this->add_field("note", new TextField([
			'label' => _('Poznámka k objednávce'),
			'required' => false,
			'widget' => new Textarea([
				'attrs' => ['rows' => 2 ],
			])
		]));
		$this->add_field("confirmation", new ConfirmationField([
			"label" => _("Souhlasím s obchodními podmínkami"),
			"required" => false // nezatrhnuti je osetreno v clean()
		]));
		$this->add_field("gdpr", new ConfirmationField([
			"label" => _("Souhlasím se zasíláním informací o novinkách, akcích a dotazníku spokojenosti zákazníků"),
			"required" => false,
		]));

		$this->set_button_text(_("Dokončit objednávku"));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors() && !$d["confirmation"]){
			$this->set_error(_("Objednávku nelze dokončit bez odsouhlasení našich obchodních podmínek."));
			$this->set_error("confirmation",_("Zatrhněte prosím souhlas s obchodními podmínkami."));
		}

		return [$err,$d];
	}
}
