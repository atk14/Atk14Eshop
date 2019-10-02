<?php
class IndexForm extends ApplicationForm{
	function set_up(){
		$this->add_search_field("q");
	}
}
