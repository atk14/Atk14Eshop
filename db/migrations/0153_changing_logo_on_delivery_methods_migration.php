<?php
class ChangingLogoOnDeliveryMethodsMigration extends ApplicationMigration {

	function up(){
		if(TEST){ return; }

		$pupiq = Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-do-ruky.png");

		if(!$pupiq){ return; }

		if($dm = DeliveryMethod::GetInstanceByCode("cpost")){
			$dm->s([
				"label_en" => "Czech Post - Parcel Delivery To Hand (payment in advance)",
				"label_cs" => "Česká Pošta - Balík do ruky (platba předem)",

				"logo" => (string)$pupiq,
			]);
		}

		if($dm = DeliveryMethod::GetInstanceByCode("cpost_cod")){
			$dm->s([
				"label_en" => "Czech Post - Parcel Delivery To Hand (cash on delivery)",
				"label_cs" => "Česká Pošta - Balík do ruky (dobírka)",

				"logo" => (string)$pupiq,
			]);
		}
	}
}
