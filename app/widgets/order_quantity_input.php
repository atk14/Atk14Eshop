<?php
class OrderQuantityInput extends NumberInput {

	function __construct($options = []){
		$options += [
			"unit" => "pcs",
			"attrs" => [],
		];

		$options["attrs"] += [
			"step" => 1,
			"min" => null,
			"max" => null,
			"xxx" => null,
			//"style" => "width: 6em;"
			"class" => "number text form-control order-quantity-input",
		];

		foreach($options["attrs"] as $k => $v){
			if(is_null($v)){ unset($options["attrs"][$k]); }
		}

		$this->unit = $options["unit"];

		parent::__construct($options);
	}

	function render($name, $value, $options=array()) {
		$out .= "<div class='js-spinner js-stepper'>";
		$out .= "<button tabindex='-1' type='button' data-spinner-button='down' title='"._("Sniž objednané množství")."'>-</button>";
		$out .= parent::render($name,$value,$options);
		$out .= "<button tabindex='-1' type='button' data-spinner-button='up' title='"._("Zvyš objednané množství")."'>+</button>";
		$out .= "&nbsp;".$this->unit;
		$out .= "</div>";
		return $out;
	}

}
