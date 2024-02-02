<?php
class Zz02AddingSystemParametersMigration extends ApplicationMigration {
	function up() {
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.tag_manager.use_datalayer",
			"system_parameter_type_id" => $type["boolean"],
			"name_en" => "Use datalayer",
			"description_en" => "Use datalayer to send data to Google Tag Manager",
			"name_cs" => "Použít datovou vrstvu",
			"description_cs" => "Použít datovou vrstvu k odeslání dat do Google Tag Manageru",
			"mandatory" => false,
		]);
	}
}
