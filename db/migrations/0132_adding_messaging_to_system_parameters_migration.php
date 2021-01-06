<?php
class AddingMessagingToSystemParametersMigration extends ApplicationMigration {

	function up(){
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		foreach([
			"skype" => "Skype",
			"icq" => "ICQ",
		] as $key => $name){
			SystemParameter::CreateNewRecord([
				"code" => "app.contact.messaging.$key",
				"system_parameter_type_id" => $type["string"],
				"name_en" => $name,
				"name_cs" => $name,
				"mandatory" => false,
				"content" => null,
			]);
		}
	}
}
