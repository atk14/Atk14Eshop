<?php
class OrderQuantityInput extends NumberInput {

	protected $unit = null;

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
			"class" => "form-control form-control-number order-quantity-input js-order-quantity-input",
			"aria-label" => _("Množství")
		];

		foreach($options["attrs"] as $k => $v){
			if(is_null($v)){ unset($options["attrs"][$k]); }
		}

		$this->unit = $options["unit"];

		parent::__construct($options);
	}

	function render($name, $value, $options=array()) {
		$out .= "<div class='quantity-widget js-spinner js-stepper'>";
		$out .= "<button tabindex='-1' type='button' data-spinner-button='down' class='btn btn-secondary' title='"._("Sniž objednané množství")."'>-</button>";
		$out .= parent::render($name,$value,$options);
		$out .= "<button tabindex='-1' type='button' data-spinner-button='up' class='btn btn-secondary' title='"._("Zvyš objednané množství")."'>+</button>";
		$out .= "&nbsp;".$this->unit;
		$out .= "</div>";
		return $out;
	}

}
