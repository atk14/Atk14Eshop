<?php
class ApplicationForm extends Atk14Form{

	/**
	 * Text on submit button 
	 */
	protected $button_text = null;

	/**
	 * 
	 */
	function pre_set_up(){
		// submit method GET is automatically set in IndexForm or DetailForm (or Users\IndexForm, Users\DetailForm, ...)
		if(preg_match('/^(|.*\\\\)(Index|Detail)Form$/i',get_class($this))){ 
			$this->set_method("get");
		}
	}

	/**
	 * The main setup method
	 */
	function set_up(){

	}

	/**
	 * 
	 */
	function post_set_up(){
		
	}

	/**
	 * Has this form only a few fields and so on a page it appears to be small?
	 * 
	 * This method is used in partial template app/views/shared/_form.tpl
	 */
	function is_small(){
		return sizeof($this->fields)<=4;
	}

	/**
	 * Sets text on the form`s submit button
	 * 
	 * See partial template app/views/shared/_form_button.tpl
	 */
	function set_button_text($text){
		$this->button_text = $text;
	}

	/**
	 * Returns text on the form`s submit button
	 * 
	 * See partial template app/views/shared/_form_button.tpl
	 */
	function get_button_text(){
		if($this->button_text){ return $this->button_text; }
		switch(get_class($this)){
			case "CreateNewForm":
				return _("Create");
			case "DetailForm":
				return _("Show");
			case "IndexForm":
				return _("Search");
			case "EditForm":
				return _("Update");
			case "DestroyForm":
				return _("Delete");
			default:
				return _("Save");
		}
	}

	/**
	 *
	 * $this->add_search_field("q");
	 * $this->add_search_field(array("label" => "Vyhledávání"));
	 */
	function add_search_field($name = "",$options = array()){
		if(is_array($name)){
			$options = $name;
			$name = "";
		}
		$name = $name=="" ? "search" : $name;
		$options += array(
			"label" => _("Hledat"),
			"required" => false,
		);
		$this->add_field($name,new SearchField($options));
	}

	/**
	 * $this->_add_address_fields();
	 */
	function _add_firstname_lastname($options = []){
		$options += [
			"prefix" => "",
			"required" => true,
		];
		$prefix = $options["prefix"];
		$required = $options["required"];


		$this->add_field("{$prefix}firstname", new CharField(array(
			"label" => _("Firstname"),
			"max_length" => 255,
			"required" => $required,
		)));

		$this->add_field("{$prefix}lastname", new CharField(array(
			"label" => _("Lastname"),
			"max_length" => 255,
			"required" => $required,
		)));
	}

	function _add_email(){
		$this->add_field("email", new EmailField(array(
			"label" => _("Email address"),
			"max_length" => 255,
			"initial" => "@"
		)));
	}

	/**
	 *	$this->_add_company_fields();
	 *	$this->_add_company_fields(["prefix" => "delivery_", required" => false]);
	 */
	function _add_address_fields($options = []){
		$options += [
			"prefix" => "",
			"required" => true,
			"add_note" => true,
			"add_address_street2" => false,
			"only_allowed_countries_for_delivery" => false,
			"disabled" => false,
		];
		$prefix = $options["prefix"];
		$required = $options["required"];
		$disabled = $options["disabled"];

		$this->add_field("{$prefix}address_street", new CharField([
			"label" => _("Ulice a č.p."),
			"max_length" => 255,
			"required" => $required,
			"disabled" => $disabled,
		]));

		if($options["add_address_street2"]){
			// Adresu 2 uz defaultne nechteji
			
			$this->add_field("{$prefix}address_street2", new CharField([
				"label" => _("Adresa (2. řádek)"),
				"max_length" => 255,
				"required" => false,
				"disabled" => $disabled,
			]));
		}

		$this->add_field("{$prefix}address_city", new CharField([
			"label" => _("City"),
			"max_length" => 255,
			"required" => $required,
			"disabled" => $disabled,
		]));
		$this->add_field("{$prefix}address_state", new CharField([
			"label" => _("State / Province / Region"),
			"max_length" => 255,
			"required" => false,
			"disabled" => $disabled,
		]));
		$this->add_field("{$prefix}address_zip", new ZipField([
			"label" => _("PSČ"),
			"required" => $required,
			"disabled" => $disabled,
		]));

		//$all_allowed_countries = Region::GetDeliveryCountriesFromAllRegions();
		// Fakturacni adresa by mela byt zadatelna pro kazdy stat na svete..
		$all_allowed_countries = null;

		$current_region_countries = $this->controller->current_region->getDeliveryCountries();
		$initial = null;
		if(($required && $current_region_countries) || ($options["only_allowed_countries_for_delivery"] && sizeof($current_region_countries)==1)){
			$initial = $current_region_countries[0];
		}
		$this->add_field("{$prefix}address_country",new CountryField(array(
			"label" => _("Země"),
			"initial" => $initial,
			"required" => $required,
			"disabled" => $disabled,
			"allowed_countries" => ($options["only_allowed_countries_for_delivery"] ? $current_region_countries : $all_allowed_countries),
			"empty_choice_text" => "-- "._("země")." --",
		)));

		$options["add_note"] && $this->add_field("{$prefix}address_note", new CharField(array(
			"label" => _("Poznámka"),
			"max_length" => 255,
			"required" => false,
			"disabled" => $disabled,
			"help_text" => _("Např. číslo patra nebo dveří"),
		)));
	}

	function _add_company_fields($options = []){
		$options += [
			"prefix" => "",
			"required" => false,
			"disabled" => false,
			"add_company_number" => true,
			"add_vat_id" => true,
			"enable_vat_id_validation" => true,
		];
		$prefix = $options["prefix"];
		$required = $options["required"];
		$disabled = $options["disabled"];

		$this->add_field("{$prefix}company", new CharField([
			"label" => _("Společnost"),
			"max_length" => 255,
			"required" => $required,
			"disabled" => $disabled,
		]));
		$options["add_company_number"] && $this->add_field("{$prefix}company_number", new IcoField([
			"label" => _("IČ"),
			"required" => $required,
			"disabled" => $disabled,
		]));
		$options["add_vat_id"] && $this->add_field("{$prefix}vat_id", new VatNumberField([
			"label" => _("DIČ"),
			"required" => $required,
			"enable_validation" => $options["enable_vat_id_validation"], // 
			"disabled" => $disabled,
		]));
	}

	function _add_phone($options = []){
		$sample_phone = "+420.605123456";
		$default_country_code = "420";

		if(isset($this->controller) && isset($this->controller->current_region) && $this->controller->current_region->getCode()=="SK"){
			$sample_phone = "+421.905123456";
			$default_country_code = "421";
		}

		$options += [
			"name" => "phone",
			"prefix" => "",

			"label" => _("Telefon"),
			"help_text" => sprintf(_("Telefonní číslo zadejte ve formátu %s"),$sample_phone),
			"required" => true,
			"default_country_code" => $default_country_code,
		];

		$name = $options["name"];
		unset($options["name"]);

		$prefix = $options["prefix"];
		unset($options["prefix"]);

		$this->add_field("$prefix$name", new PhoneField($options));
	}

	/**
	 * Pokud je ve formulari DIC a zeme fakturacni adresy, zvaliduje to, ze si sobe odpovidaji.
	 */
	function _clean_vat_id_and_country($vat_id = "vat_id", $address_country = "address_country"){
		$d = $this->cleaned_data;

		if(is_array($d) && isset($d[$vat_id]) && strlen($d[$vat_id]) && isset($d[$address_country]) && strlen($d[$address_country])){
			$vat_country = substr($d[$vat_id],0,2);
			if($d[$address_country]!==$vat_country){
				$this->set_error(_("Země ve fakturační adrese a země v DIČ se musí shodovat"));
			}
		}
	}
}
