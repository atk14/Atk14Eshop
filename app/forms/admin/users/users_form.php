<?php
class UsersForm extends AdminForm{

	var $has_password_field = false;

	function set_up(){
		$this->add_field("login",new LoginField(array(
			"check_for_conflicted_user_existence" => false,
		)));

		if($this->has_password_field){
			$this->add_field("password",new PasswordField(array(
				"required" => false,
				"trim_value" => true,
				"null_empty_output" => true,
			)));
		}
	
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
			"initial" => $anonymous ? $anonymous->g("pricelist_id") : null,
		)));

		$this->add_field("base_pricelist_id", new PricelistField(array(
			"label" => _("Ceník s cenami před slevou"),
			"required" => false,
			"initial" => $anonymous ? $anonymous->g("base_pricelist_id") : null,
		)));

		$this->add_field("customer_groups", new ManuallyAssignableCustomerGroupsField([
			"label" => _("Customer groups"),
			"required" => false,
		]));

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

	function clean(){
		list($err,$values) = parent::clean();
	
		if(isset($values["login"])){
			$form_class = get_class($this);
			$msg_conflict = _("The same login is already used for another user");
			if(preg_match('/CreateNewForm/',$form_class)){

				if(User::FindByLogin($values["login"])){
					$this->set_error("login",$msg_conflict);
				}

			}elseif(preg_match('/EditForm/',$form_class)){
				
				$editing_user = User::GetInstanceById($this->controller->params->getInt("id"));
				if(($u = User::FindByLogin($values["login"])) && $u->getId()!=$editing_user->getId()){
					$this->set_error("login",$msg_conflict);
				}
			}
		}

		return array($err,$values);
	}
}
