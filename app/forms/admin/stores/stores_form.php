<?php
class StoresForm extends AdminForm {

	function set_up()	{
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		$this->add_translatable_field("teaser", new CharField(array(
			"label" => _("Brief description"),
			"required" => false,
		)));

		$this->add_field("image_url", new PupiqImageField(array(
			"label" => _("Image"),
			"required" => false,
		)));

		$this->add_field("email", new EmailField(array(
			"label" => _("Email"),
			"max_length" => 255,
			"required" => false,
		)));

		$this->add_field("phone", new PhoneField(array(
			"label" => _("Phone"),
			"required" => false,
		)));

		foreach([
			"address_street" => _("Street"),
			"address_street2" => _("Street (2nd line)"),
			"address_city" => _("City"),
		] as $k => $label){
			$this->add_field($k,new CharField([
				"label" => $label,
				"required" => false,
				"max_length" => 255,
			]));
		}
		$this->add_field("address_zip",new ZipField([
			"label" => _("ZIP"),
			"required" => false,
		]));
		$this->add_field("address_country", new CountryField([
			"label" => _("Stát"),
			"required" => false,
			"initial" => "CZ",
		]));

		$this->add_field("location_lat", new FloatField([
			"label" => _("Latitude"),
			"hint" => "50.0876229",
			"required" => false,
			"help_text" => _("Enter latitude (e.g. 50.0876229) or paste coordinates (e.g. 50.7326181N, 14.9850481E)"),
		]));

		$this->add_field("location_lng", new FloatField([
			"label" => _("Longitude"),
			"hint" => "14.4639075",
			"required" => false,
			"help_text" => _("Enter longitude (e.g. 14.4639075) or paste coordinates (e.g. 50.7326181N, 14.9850481E)"),
		]));

		$this->add_translatable_field("address", new TextField(array(
			"label" => _("Address"),
			"required" => false,
		)));

		foreach([
			"mon" => _("Monday"),
			"tue" => _("Tuesday"),
			"wed" => _("Wednesday"),
			"thu" => _("Thursday"),
			"fri" => _("Friday"),
			"sat" => _("Saturday"),
			"sun" => _("Sunday")
		] as $k => $day){
			$this->add_field("opening_hours_{$k}1",new HourField([
				"label" => sprintf(_("Otevřeno v %s od"),$day),
				"initial" => "9:00",
				"required" => false,
			]));
			$this->add_field("opening_hours_{$k}2",new HourField([
				"label" => sprintf(_("Otevřeno v %s do"),$day),
				"initial" => "21:00",
				"required" => false,
			]));
		}

		$this->add_translatable_field("opening_hours", new TextField(array(
			"label" => _("Opening hours"),
			"required" => false,
		)));

		$this->add_translatable_field("description", new MarkdownField(array(
			"label" => _("Description"),
			"required" => false,
		)));

		$field = $this->add_code_field();
		if(isset($this->controller->store) && $this->controller->store->getCode()=="eshop"){
			$field->disabled = true;
		}

		$this->add_visible_field(array(
			"label" => _("Is visible in the public list on web?")
		));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(array_key_exists("location_lat",$d) && array_key_exists("location_lng",$d)){
			if((is_null($d["location_lat"]) + is_null($d["location_lng"]))==1){ // true + false or false + true -> 1
				$this->set_error(_("Either fill out Latitude and Longitude or leave them blank."));
			}
		}

		return array($err,$d);
	}
}
