<?php
class AddingSystemParametersMigration extends ApplicationMigration {
	
	function up(){
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		SystemParameter::CreateNewRecord([
			"code" => "orders.notifications.shipping_days",
			"system_parameter_type_id" => $type["text"],
			"description_en" => "Usual number of days for order delivery",
			"description_cs" => "Obvyklý počet dnů pro doručení objednávky",
			"content" => "1-2",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "orders.notifications.special_note",
			"system_parameter_type_id" => $type["localized_text"],
			"description_en" => "Extra note in email order recap. Do not use HTML tags. New lines will be converted to <br/> automatically.",
			"description_cs" => "Mimořádna poznámka v e-mailové rekapitulaci objednávky. Nepoužívejte HTML značky. Nové řádky budou převedeny na <br/> automaticky.",
		]);
	}
}
