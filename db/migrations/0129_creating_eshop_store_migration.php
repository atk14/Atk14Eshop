<?php
class CreatingEshopStoreMigration extends ApplicationMigration {

	function up(){
		Store::CreateNewRecord(array(
			"code" => "eshop",
			"visible" => false,
			
			"name_en" => "Eshop",
			"name_cs" => "E-shop",

			"email" => "your@email.com",
			"phone" => "+420.605123456",
			
			"address_street" => "Zahnutá 123",
			"address_city" => "Praha 3",
			"address_zip" => "130 00",
			"address_country" => "CZ",
		));
	}
}
