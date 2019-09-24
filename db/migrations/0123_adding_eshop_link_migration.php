<?php
class AddingEshopLinkMigration extends ApplicationMigration {

	function up(){
		$ll = LinkList::GetInstanceByCode("main_menu");
		if(!$ll){ return; }

		$item = LinkListItem::CreateNewRecord([
			"link_list_id" => $ll,
			"title_en" => "E-shop",
			"title_cs" => "Obchod",
			"url" => $this->_link_to_category("catalog"),
			"regions" => json_encode(["CZ" => true])
		]);
		$item->setRank(0);
	}
}
