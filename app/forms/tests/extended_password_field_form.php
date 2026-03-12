<?php
class ExtendedPasswordFieldForm extends ApplicationForm {

	function set_up(){
		if(class_exists("ExtendedPasswordField")){

		$this->add_field("p1", new ExtendedPasswordField([
			"label" => "Ext. password",
			"help_text" => "Help text",
		]));

		$this->add_field("p2", new ExtendedPasswordField([
			"label" => "Ext. password, min 70%",
			"minimum_password_strength_required" => 70,
			"help_text" => "Help text",
		]));

		$this->add_field("p3", new ExtendedPasswordField([
			"label" => "Ext. password, no password revealing",
			"enable_password_reveal" => false,
			"help_text" => "Help text",
		]));

		$this->add_field("p4", new ExtendedPasswordField([
			"label" => "Ext. password, no progress bar",
			"show_password_strength_progressbar" => false,
			"help_text" => "Help text",
		]));

		}

		$this->add_field("p5", new PasswordField([
			"label" => "Ord. Password",
			"help_text" => "Help text",
		]));

		$this->set_button_text("Send");
	}
}
