<?php
class TestingRegionsMigration extends ApplicationMigration {

	function up(){
		if(!DEVELOPMENT){ return; }

		($default = Region::FindByCode("DEFAULT")) &&
		$default->s([
			"name_en" => "Czechia",
			"name_cs" => "Česká republika",
		]);

		($sk = Region::FindByCode("SK")) ||
		($sk = Region::CreateNewRecord([
			"code" => "SK",
			"name_en" => "Slovakia",
			"name_cs" => "Slovensko",
			"languages" => '["cs","en"]',
			"currencies" => '["EUR"]',
			"delivery_countries" => '["SK"]',
		]));

		($eu = Region::FindByCode("EU")) ||
		($eu = Region::CreateNewRecord([
			"code" => "EU",
			"name_en" => "EU",
			"name_cs" => "EU",
			"languages" => '["cs","en"]',
			"currencies" => '["EUR"]',
			"delivery_countries" => '["DE","AT","HU","PL","BE","FR","NL","GB","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"]',
		]));

		foreach(DeliveryMethod::FindAll() as $o){
			$o->s("regions",'{"DEFAULT":true,"SK":true,"EU":true}');
		}

		foreach(PaymentMethod::FindAll() as $o){
			$o->s("regions",'{"DEFAULT":true,"SK":true,"EU":true}');
		}

		$regions = '{"DEFAULT": true, "SK": true, "EU": true}';
		foreach([
			"delivery_methods",
			"payment_methods",
			"campaigns",
			"digital_contents",
			"link_list_items",
		] as $table){
			$this->dbmole->doQuery("UPDATE $table SET regions=:regions",[":regions" => $regions]);
		}
	}
}
