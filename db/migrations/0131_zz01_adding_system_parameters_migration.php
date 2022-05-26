<?php
class Zz01AddingSystemParametersMigration extends ApplicationMigration {
	function up() {
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.ads.use_enhanced_conversion.manual_gtm",
			"system_parameter_type_id" => $type["boolean"],
			"name_en" => "Use enhanced conversion for Google Ads manually with Google Tag Manager",
			"description_en" => "Conversion page will contain Javascript object '<b>enhanced_conversion_data</b>' with customer data usable in Google Tag Manager",
			"name_cs" => "Použít rozšířené konverze pro Google Ads ručně pomocí Google Tag Manageru",
			"description_cs" => "Konverzní stránka bude obsahovat Javascriptový objekt '<b>enhanced_conversion_data</b>' s uživatelskými daty, který lze použít v Google Tag Manageru",
			"mandatory" => false,
		]);
	}
}
