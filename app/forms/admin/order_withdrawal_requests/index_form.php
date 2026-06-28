<?php
class IndexForm extends OrderWithdrawalRequestsForm {

	function set_up(){
		$this->add_field("search",new SearchField(array(
			"label" => _("Search"),
			"required" => false,
		)));
	}
}
