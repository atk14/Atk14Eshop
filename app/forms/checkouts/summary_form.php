<?php
// Formular pro dokonceni objednavky
class SummaryForm extends CheckoutsForm {

	function set_up(){
		$this->add_field("note", new TextField([
			'label' => _('Vaše poznámka k objednávce'),
			'required' => false,
			'max_length' => 1000,
			'widget' => new Textarea([
				'attrs' => ['rows' => 2 ],
			])
		]));
		$this->add_field("confirmation", new ConfirmationField([
			"label" => _("Souhlasím s obchodními podmínkami"),
			"required" => false // nezatrhnuti je osetreno v clean()
		]));
		$this->add_field("sign_up_for_newsletter", new BooleanField([
			"label" => _("Sign up for newsletter"),
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
