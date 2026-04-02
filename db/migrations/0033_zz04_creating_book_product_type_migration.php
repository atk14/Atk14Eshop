<?php
class Zz04CreatingBookProductTypeMigration extends ApplicationMigration {

	function up(){
		($pt = ProductType::GetInstanceByCode("book")) ||
		(
			$pt = ProductType::CreateNewRecord([
				"code" => "book",
				"name_cs" => "Kniha",
				"name_en" => "Book",
				"page_title_pattern_cs" => "%product_name% - %main_creators%",
				"page_title_pattern_en" => "%product_name% - %main_creators%",
				"slug_en" => "book",
				"slug_cs" => "kniha",
			])
		);
	}
}
