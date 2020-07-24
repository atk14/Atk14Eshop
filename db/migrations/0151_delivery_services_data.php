<?php
class DeliveryServicesData extends Atk14Migration {

	function up() {
		if (TEST) {
			return;
		}

		$services = [
			[
				"code" => "cp-balik-na-postu",
				"name" => "Česká Pošta - Balík na poštu",
			],
			[
				"code" => "cp-balikovna",
				"name" => "Česká Pošta - Balíkovna",
			],
			[
				"code" => "zasilkovna",
				"name" => "Zásilkovna",
			],
		];

		foreach($services as $values) {
			DeliveryService::CreateNewRecord($values);
		}

		SystemParameter::CreateNewRecord([
			"system_parameter_type_id" => 1,
			"code" => "delivery_services.zasilkovna.api_key",
			"name_cs" => "Zásilkovna API klíč",
			"name_en" => "Zásilkovna API key",
			"content" => "",
			"mandatory" => false,
			"description_cs" => "Klíč pro přístup k API služby Zásilkovna.cz",
			"description_en" => "Key for access to API to the service Zásilkovna.cz",
		]);
	}
}
