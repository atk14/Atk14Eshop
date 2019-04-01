<?php
class CreatingEshopStoreMigration extends ApplicationMigration {

	function up(){
		Store::CreateNewRecord(array(
			"code" => "eshop",
			"visible" => false,
			
			"name_en" => "ATK14 Eshop",
			"name_cs" => "ATK14 Eshop",

			"name_en" => "ATK14 Eshop is an skeleton suitable for eshops. It is built on top of ATK14 Catalog.",
			"name_cs" => "ATK14 E-shop je aplikační kostra vhodná pro e-shopy, která je postavena na ATK14 Katalogu.",

			"email" => "your@email.com",
			"phone" => "+420.605123456",
			
			"address_street" => "Zahnutá 123",
			"address_city" => "Praha 3",
			"address_zip" => "130 00",
			"address_country" => "CZ",
		));
	}
}
