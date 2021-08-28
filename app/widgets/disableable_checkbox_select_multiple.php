<?php
class DisableableCheckboxSelectMultiple extends CheckboxSelectMultiple {

	function __construct($options = []){
		$options += [
			"disabled_choices" => [], // e.g. ["1", "3", "9"]
		];

		$this->disabled_choices = $options["disabled_choices"];
		unset($options["disabled_choices"]);

		parent::__construct($options);
	}

	function render($name, $value, $options = []){
		$out = parent::render($name,$value,$options);
		foreach($this->disabled_choices as $value){
			if(!preg_match('/(<input.*?value="'.$value.'".*?>)/',$out,$matches)){ // TODO: $value needs to be escaped for the regular expression
				continue;
			}
			$src = $matches[1];
			$checkbox = $matches[1];
			$checkbox = preg_replace('/(\/?>)$/',' disabled="disabled"\1',$checkbox);
			if(preg_match('/checked/',$checkbox)){
				$checkbox .= sprintf('<input type="hidden" name="%s" value="%s">',h($name."[]"),h($value));
			}
			$out = str_replace($src,$checkbox,$out);
		}
		return $out;
	}
}
