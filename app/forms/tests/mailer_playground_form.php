<?php
class MailerPlaygroundForm extends TestsForm {

	function set_up(){

		$this->add_field("content", new TextField([
			"initial" => trim('
<mj-section>
  <mj-column>
    <mj-text>
Enter your MJML code here.
    </mj-text>
  </mj-column>
</mj-section>
			'),
		]));

		$this->add_field("remove_smarty_tags", new BooleanField([
			"label" => _("Remove Smarty tags?"),
		]));

		$this->set_attr("target","_blank");
		$this->set_button_text(_("Generate email"));
	}
}
