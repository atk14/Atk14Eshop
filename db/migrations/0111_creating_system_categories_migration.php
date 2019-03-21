<?php
class CreatingSystemCategoriesMigration extends ApplicationMigration {

	function up(){
		if(TEST){ return; }

		// Discounts
		$discounts = Category::CreateNewRecord([
			"code" => "discounts",
			"name_en" => "Discounts",
			"name_cs" => "Slevy",
			"visible" => false,
		]);
		foreach([5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95] as $discount_percent){
			$category = Category::CreateNewRecord([
				"parent_category_id" => $discounts,
				"name_cs" => "$discount_percent%",
				"name_en" => "$discount_percent%",
			]);

			Discount::CreateNewRecord([
				"category_id" => $category,
				"discount_percent" => $discount_percent,
			]);
		}

		// Recommended products on homepage
		$recommended_cards = Category::CreateNewRecord([
			"code" => "recommended_products_homepage",
			"visible" => false,
			"name_cs" => "Doporučujeme",
			"name_en" => "Recommended",
			"teaser_cs" => "Doporučené produkty na homepage"
		]);
	}
}
