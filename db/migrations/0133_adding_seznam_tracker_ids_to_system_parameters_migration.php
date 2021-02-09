<?php
class AddingSeznamTrackerIdsToSystemParametersMigration extends ApplicationMigration {

	function up(){
		// Creating SystemParameters
		$values_ar = [];
		$values_ar[] = [
			"code" => "app.trackers.seznam.retargeting.retargeting_id",
			"system_parameter_type_id" => SystemParameterType::GetInstanceByCode("integer"),
			"name_en" => "Seznam Retargeting ID",
			"name_cs" => "Seznam Retargeting ID",
			"description_en" => "Seznam Retargeting ID",
			"description_cs" => "Seznam Retargeting ID",
			"mandatory" => false,
		];
		$values_ar[] = [
			"code" => "app.trackers.seznam.sklik.conversion_id",
			"system_parameter_type_id" => SystemParameterType::GetInstanceByCode("integer"),
			"name_en" => "Seznam Sklik Conversion ID",
			"name_cs" => "Seznam Sklik ID konverze",
			"description_en" => "Seznam Sklik Conversion ID",
			"description_cs" => "Seznam Sklik ID konverze",
			"mandatory" => false,
		];
		foreach($values_ar as $values){
			SystemParameter::GetInstanceByCode($values["code"]) ||
			SystemParameter::CreateNewRecord($values);
		}
	}
}
