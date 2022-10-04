<?php
class CreateNewForm extends ApplicationForm {

	function set_up(){
		$this->add_field("email", new EmailField([
			"label" => _("E-mail"),
			"max_length" => 255,
			"required" => !$this->controller->logged_user,
			"initial" => $this->controller->logged_user ? $this->controller->logged_user->getEmail() : null,
			"null_empty_output" => true,
		]));

		if(!$this->controller->logged_user && defined("RECAPTCHA_SITE_KEY") && defined("RECAPTCHA_SECRET_KEY")){
			$this->add_field("captcha", new RecaptchaField([
				"label" => _("Kontrola"),
			]));
		}

		$this->set_button_text(_("Aktivovat hlídacího psa"));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(is_array($d)){
			unset($d["captcha"]);
		}

		return [$err,$d];
	}
}
