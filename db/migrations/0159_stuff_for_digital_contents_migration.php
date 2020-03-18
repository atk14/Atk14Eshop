<?php
class StuffForDigitalContentsMigration extends ApplicationMigration {

	function up(){
		$tag = Tag::CreateNewRecord([
			"code" => "digital_product",
			"tag" => "digital product",
			"tag_localized_en" => "digital product",
			"tag_localized_cs" => "digitální produkt", 
		]);

		$digital_delivery = DeliveryMethod::CreateNewRecord([
			"code" => "digital_delivery",
			"label_cs" => "Stažení digitálního produktu",
			"label_en" => "Digital product download",
			"logo" => "https://i.pupiq.net/i/65/65/94b/2e94b/276x276/K21inD_276x276_2e7fc2c12cf20eae.png",
			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => '{"DEFAULT": true}',
			"required_tag_id" => $tag,
		]);

		$bank_transfer = PaymentMethod::GetInstanceByCode("bank_transfer");
		
		if($bank_transfer){
			ShippingCombination::CreateNewRecord([
				"delivery_method_id" => $digital_delivery,
				"payment_method_id" => $bank_transfer,
			]);
		}
	}
}
