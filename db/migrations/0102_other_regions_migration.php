<?php
class OtherRegionsMigration extends ApplicationMigration {

	function up(){
		if(!DEVELOPMENT){ return; } // It should be executed only in DEVELOPMENT
	
		$czech_republic = Region::GetInstanceByCode("DEFAULT");
		if($czech_republic){
			$czech_republic->s([
				"name_en" => "Czech Republic",
				"name_cs" => "Česká republika",
			]);
		}

		($slovakia = Region::GetInstanceByCode("SK")) || 
		($slovakia = Region::CreateNewRecord([
			"code" => "SK",
			"name_en" => "Slovakia",
			"name_cs" => "Slovensko",
			"domains" => '[]',
			"languages" => '["cs","en"]',
			"currencies" => '["EUR"]',
			"delivery_countries" => '["SK"]',
		]));

		($eu = Region::GetInstanceByCode("EU")) ||
		($eu = Region::CreateNewRecord([
			"code" => "EU",
			"name_en" => "EU",
			"name_cs" => "EU",
			"domains" => '[]',
			"languages" => '["en"]',
			"currencies" => '["EUR"]',
			"delivery_countries" => '["DE","AT","HU","PL","BE","FR","NL","GB","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"]',
		]));
	}
}
