<?php
class Zz01FixingGlsDeliveryMethodsMigration extends ApplicationMigration {

	function up(){
		foreach([
			"gls" => "gls_parcel_shop",
			"gls_cod" => "gls_parcel_shop_cod",
		] as $current_code => $new_code){
			$current_dm = DeliveryMethod::GetInstanceByCode($current_code);
			$new_dm = DeliveryMethod::GetInstanceByCode($new_code);

			if($current_dm && !$new_dm){
				$current_dm->s("code",$new_code);
			}
		}
	}
}
