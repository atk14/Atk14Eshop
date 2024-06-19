<?php
class Zz03GiftVoucherProductTypeMigration extends ApplicationMigration {

	function up(){
		if(ProductType::GetInstanceByCode("gift_voucher")){ return; }

		ProductType::CreateNewRecord([
			"code" => "gift_voucher",
			//
			"name_cs" => "dárkový poukaz",
			"name_en" => "gift voucher",
			"name_sk" => "darčeková poukážka",
			//
			"page_title_pattern_cs" => "%product_name%",
			"page_title_pattern_en" => "%product_name%",
			"page_title_pattern_sk" => "%product_name%",
			//
			"slug_cs" => "poukaz",
			"slug_en" => "voucher",
			"slug_sk" => "poukazka",
		]);
	}
}

