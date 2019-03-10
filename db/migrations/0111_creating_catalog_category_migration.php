<?php
class CreatingCatalogCategoryMigration extends ApplicationMigration {

	function up(){
		$catalog = Category::CreateNewRecord([
			"code" => "catalog",
			"name_en" => "Catalog",
			"name_cs" => "Katalog",
		]);

		foreach(Category::FindAll("parent_category_id IS NULL AND id!=:catalog",[":catalog" => $catalog]) as $root_category){
			$root_category->s("parent_category_id",$catalog);
		}
	}
}
