<?php
class EditForm extends SystemParametersForm {

	function set_up(){
	}

	function prepare_for($system_parameter){
		$this->system_parameter = $system_parameter;

		$type = $system_parameter->getSystemPArameterType()->getCode();

		$params = [
			"required" => $system_parameter->isMandatory(),
			"disabled" => $system_parameter->isReadOnly()
		];

		switch($type){

			case "text":

				$this->add_field("content", new TextField($params + [
					"label" => _("Textual value"),
					"trim_value" => true,
					"null_empty_output" => true,
				]));
				break;

			case "localized_text":

				$this->add_translatable_field("content_localized", new TextField($params + [
					"label" => _("Textual value"),
					"trim_value" => true,
					"null_empty_output" => true,
				]));
				break;

			case "string":

				$this->add_field("content", new CharField($params + [
					"label" => _("String value"),
					"trim_value" => true,
					"null_empty_output" => true,
				]));
				break;

			case "localized_string":

				$this->add_translatable_field("content_localized", new CharField($params + [
					"label" => _("String value"),
					"trim_value" => true,
					"null_empty_output" => true,
				]));
				break;

			case "integer":

				$this->add_field("content", new IntegerField($params + [
					"label" => _("Integer value"),
				]));
				break;


			case "boolean":

				$this->add_field("content", new ChoiceField($params + [
					"label" => _("Boolean value"),
					"choices" => [
						"" => "",
						"TRUE" => _("Yes"),
						"FALSE" => _("No"),
					],
					"null_empty_output" => true,
				]));
				break;

			case "url":

				$this->add_field("content", new UrlField($params + [
					"label" => _("URL"),
				]));
				break;

			case "image_url":

				$this->add_field("content", new PupiqImageField($params + [
					"label" => _("Image"),
				]));
				break;

			case "email":

				$this->add_field("content", new EmailField($params + [
					"label" => _("Email"),
				]));
				break;

			case "phone":

				$this->add_field("content", new PhoneField($params + [
					"label" => _("Phone number"),
				]));
				break;

			default:

				throw new Exception("Hey! Add field for $type");

		}
	}
}
