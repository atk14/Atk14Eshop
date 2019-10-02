<?php
class UsersForm extends AdminForm{

	function set_up(){
		$this->add_field("firstname", new CharField(array(
			"label" => _("Firstname"),
			"max_length" => 255,
		)));

		$this->add_field("lastname", new CharField(array(
			"label" => _("Lastname"),
			"max_length" => 255,
		)));

		$this->add_field("email",new EmailField(array(
			"label" => _("Email address"),
			"max_length" => 255,
		)));

		$anonymous = User::GetAnonymousUser();

		$this->add_field("pricelist_id", new PricelistField(array(
			"label" => _("Ceník"),
			"initial" => $anonymous->g("pricelist_id"),
		)));

		$this->add_field("base_pricelist_id", new PricelistField(array(
			"label" => _("Ceník s cenami před slevou"),
			"required" => false,
			"initial" => $anonymous->g("base_pricelist_id"),
		)));

		$this->add_field("active",new BooleanField(array(
			"label" => _("Is active?"),
			"required" => false,
			"initial" => true,
			"help_text" => _("Inactive user can not be logged in"),
		)));

		$this->add_field("is_admin",new BooleanField(array(
			"label" => _("Is admin?"),
			"required" => false,
		)));
	}
}
