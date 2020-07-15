<?php
class EditForm extends OrderCampaignsForm {

	function set_up(){
		parent::set_up();

		$this->fields["campaign_id"]->disabled = true;
	}
}
