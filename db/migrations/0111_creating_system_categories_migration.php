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

		$system = Category::CreateNewRecord([
			"code" => "system",
			"visible" => false,
			"name_cs" => "Systém",
			"name_en" => "System",
			"teaser_cs" => "Kategorie pro systémové potřeby",
			"teaser_en" => "Category for system needs",
		]);

		// Recommended products on homepage
		$category_recommended_cards = Category::CreateNewRecord([
			"parent_category_id" => $system,
			"code" => "recommended_cards_homepage",
			"visible" => true,
			"name_cs" => "Doporučené produkty",
			"name_en" => "Recommended products",
			"teaser_cs" => "Z naší nabídky doporučujeme vaší pozornosti následující produkty.",
			"teaser_en" => "From our offer we recommend the following products.",
		]);

		$category_recommended_cards->addCard(Card::FindFirst());
	}
}
