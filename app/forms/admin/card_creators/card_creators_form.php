<?php
class CardCreatorsForm extends AdminForm {

	function set_up(){
		$this->add_field("creator_id", new CreatorField([
			"label" => _("Creator"),
			"create_creator_if_not_found" => true,
		]));
		$this->add_field("creator_role_id", new CreatorRoleField([
			"label" => _("Role"),
			"help_text" => sprintf(_('Missing a role? &rarr; <a href="%s">create it</a>'),Atk14Url::BuildLink(["action" => "creator_roles/create_new"])),
		]));
		$this->add_field("is_main_creator", new BooleanField([
			"label" => _("Is this the main creator?"),
			"required" => false,
		]));
	}
}
