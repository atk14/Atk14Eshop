<?php
class DeliveryMethodCountrySpecificationsController extends AdminController {

	function create_new(){
		$delivery_method = $this->_just_find("delivery_method","delivery_method_id");
		$country = $this->params->getString("country");

		if(!$delivery_method || !preg_match('/^[A-Z]{2}$/',$country)){
			return $this->_execute_action("error404");
		}

		$this->_create_new([
			"page_title" => $this->_get_page_title($country),
			"create_closure" => function($d) use ($delivery_method,$country) {
				$d["delivery_method_id"] = $delivery_method;
				$d["country"] = $country;
				return DeliveryMethodCountrySpecification::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => $this->_get_page_title($this->delivery_method_country_specification->getCountry()),
		]);
	}

	function _get_page_title($country_code){
		Atk14Require::Helper("modifier.to_country_name");
		return sprintf(_("Specifické hodnoty dopravy pro %s"),smarty_modifier_to_country_name($country_code));
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("delivery_method_country_specification");
		}
	}
}
