<?php
class Zz04AddingWatchdogSystemParametersMigration extends ApplicationMigration {

	function up(){
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		foreach([
			"notification_delay_minutes" => [
				"content" => "0",
				"name_en" => "Delay before sending a watchdog notification (minutes)",
				"name_cs" => "Zpoždění odeslání notifikace hlídacího psa (v minutách)",
			],
			"notification_stagger_minutes" => [
				"content" => "0",
				"name_en" => "Gap between notifying successive watchers of the same product (minutes)",
				"name_cs" => "Prodleva mezi notifikacemi jednotlivých zájemců o stejný produkt (v minutách)",
			],
			"notification_stagger_limit" => [
				"content" => "0",
				"name_en" => "Number of watchers to stagger before notifying the rest at once (0 = no limit)",
				"name_cs" => "Počet zájemců, u kterých se ještě rozkládá odeslání v čase, než se zbytek notifikuje najednou (0 = bez omezení)",
			],
		] as $key => $values){
			$values += [
				"code" => "watchdog.$key",
				"system_parameter_type_id" => $type["integer"],
				"mandatory" => true,
			];
			SystemParameter::CreateNewRecord($values);
		}
	}
}
