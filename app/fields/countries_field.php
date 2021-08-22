<?php
class CountriesField extends CharField {

	function __construct($options = []){
		$options += [
			"json_encode" => true,
		];
		$options["null_empty_output"] = true;

		$this->json_encode = $options["json_encode"];
		unset($options["json_encode"]);

		parent::__construct($options);

		$this->update_messages([
			"invalid_country_code" => _("Country with code %country_code% does not exist."),
			"duplicate_country_code" => _("Country code %country_code% is given more than once."),
			"invalid" => _("Please, write comma-separated list of country codes"),
			"required" => _("Please, write comma-separated list of country codes"),
		]);
	}

	function format_initial_data($data){
		if(is_string($data)){
			$d = json_decode($data,true);
			if(is_array($d)){
				$data = $d;
			}
		}
		if(is_array($data)){
			$data = join(", ",$data);
		}
		return $data;
	}

	function clean($value){
		list($err,$value) = parent::clean($value);

		if(!is_null($err)){
			return [$err,null];
		}

		if(is_null($value)){
			$value = [];
			if($this->json_encode){
				$value = json_encode($value);
			}
			return [null,$value];
		}

		$value = trim($value);
		$value = strtoupper($value);
		$codes = preg_split('/[^A-Z]+/',$value);

		$country_list = CountryListLoader::Get(); // CountryListLoader is from atk14/country-field

		$value = [];
		foreach($codes as $code){
			if($code==""){
				return [$this->messages["invalid"],null];
			}
			if(!isset($country_list[$code])){
				$err_msg = str_replace("%country_code%",h($code),$this->messages["invalid_country_code"]);
				return [$err_msg,null];
			}
			if(in_array($code,$value)){
				$err_msg = str_replace("%country_code%",h($code),$this->messages["duplicate_country_code"]);
				return [$err_msg,null];
			}
			$value[] = $code;
		}

		if($this->json_encode){
			$value = json_encode($value);
		}

		return [$err, $value];
	}
}
