<?php
class UpdatingCatalogCategoryMigration extends ApplicationMigration {

	function up(){
		if(TEST){ return; }

		$catalog = Category::GetInstanceByCode("catalog");

		if(!$catalog){ return; }

		$catalog->s([
			"name_en" => "Eshop",
			"name_cs" => "Obchod",
			"slug_en" => "eshop",
			"slug_cs" => "obchod",
		]);
	}
}
