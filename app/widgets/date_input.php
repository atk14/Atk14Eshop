<?php
class DateInput extends TextInput {
	function __construct($options=array()) {
		$this->attrs = array(
			"class" => "text calendar_field",
		);
		!isset($options["attrs"]) && ($options["attrs"] = array());
		$options["attrs"] = forms_array_merge($this->attrs,$options["attrs"]);
		parent::__construct($options);
	}
}
