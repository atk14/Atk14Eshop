<?php
class SecondaryMenuMigration extends ApplicationMigration {

	function up(){
		if(TEST){ return; }

		$regions = [];
		foreach(Region::FindAll() as $region){
			$regions[$region->getCode()] = true;
		}
		$regions = json_encode($regions);

		$secondary_menu = LinkList::GetInstanceByCode("secondary_menu");
		if(!$secondary_menu){
			$secondary_menu = LinkList::CreateNewRecord([
				"system_name" => "Sekundárni menu - desktop",
				"code" => "secondary_menu",
			]);

			LinkListItem::CreateNewRecord([
				"link_list_id" => $secondary_menu,
				"title_en" => "Store Locator",
				"title_cs" => "Prodejny",
				"url" => "/prodejny/",
				"regions" => $regions,
			]);

			LinkListItem::CreateNewRecord([
				"link_list_id" => $secondary_menu,
				"title_en" => "About us",
				"title_cs" => "O nás",
				"url" => "/o-nas/",
				"regions" => $regions,
			]);

			LinkListItem::CreateNewRecord([
				"link_list_id" => $secondary_menu,
				"title_en" => "Blog",
				"title_cs" => "Články",
				"url" => "/clanky/",
				"regions" => $regions,
			]);

			LinkListItem::CreateNewRecord([
				"link_list_id" => $secondary_menu,
				"title_en" => "Contacts",
				"title_cs" => "Kontakt",
				"url" => "/o-nas/kontaktni-udaje/",
				"regions" => $regions,
			]);
		}

		if(!LinkList::GetInstanceByCode("secondary_menu_mobile")){
			$secondary_menu_mobile =  LinkList::CreateNewRecord([
				"system_name" => "Sekundárni menu - mobil",
				"code" => "secondary_menu_mobile",
			]);

			foreach($secondary_menu->getItems() as $item){
				LinkListItem::CreateNewRecord([
					"link_list_id" => $secondary_menu_mobile,
					"title_en" => $item->g("title_en"),
					"title_cs" => $item->g("title_cs"),
					"url" => $item->g("url"),
					"regions" => $item->g("regions"),
				]);
			}
		}
	}
}
