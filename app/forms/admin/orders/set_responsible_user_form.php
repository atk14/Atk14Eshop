<?php
class SetResponsibleUserForm extends AdminForm {

	function set_up() {
		$this->add_field("responsible_user_id", new AdminField([
			"label" => _("Uživatel"),
			"user_required" => $this->controller->order->getResponsibleUserId(),
		]));

		$this->set_button_text(_("Nastavit zodpovědnou osobu"));
	}
}
