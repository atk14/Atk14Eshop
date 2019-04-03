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

		if($type=="text"){

			$this->add_field("content", new TextField($params + [
				"label" => _("Textual value"),
				"trim_value" => true,
				"null_empty_output" => true,
			]));

		}elseif($type=="integer"){

			$this->add_field("content", new IntegerField($params + [
				"label" => _("Integer value"),
			]));

		}elseif($type=="localized_text"){

			$this->add_translatable_field("content_localized", new TextField($params + [
				"label" => _("Textual value"),
				"trim_value" => true,
				"null_empty_output" => true,
			]));
			
		}else{

			throw new Exception("Hey! Add field for $type");

		}
	}
}
