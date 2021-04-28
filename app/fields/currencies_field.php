<?php
class CurrenciesField extends MultipleChoiceField {

	function __construct($options = []){
		$choices = [];
		foreach(Currency::FindAll() as $currency){
			$choices[$currency->getCode()] = $currency->getCode(); 
		}

		$options += array(
			"choices" => $choices,
			"widget" => new CheckboxSelectMultiple(),
			"json_encode" => true,
		);

		$this->json_encode = $options["json_encode"];
		unset($options["json_encode"]);

		parent::__construct($options);
	}

	function format_initial_data($data){
		if(is_string($data)){
			$d = json_decode($data,true);
			if(is_array($d)){
				return $d;
			}
		}
		return $data;
	}

	function clean($value){
		list($err,$value) = parent::clean($value);

		if(!is_null($err) || is_null($value)){
			return [$err,$value];
		}

		if($this->json_encode){
			$value = json_encode($value);
		}

		return [ $err, $value ];
	}
}
