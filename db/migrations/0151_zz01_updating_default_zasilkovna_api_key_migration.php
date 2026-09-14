<?php
class Zz01UpdatingDefaultZasilkovnaApiKeyMigration extends ApplicationMigration {

	function up(){
		if(SystemParameter::ContentOn("delivery_services.zasilkovna.api_key")==="41494564a70d6de6"){
			$sp = SystemParameter::GetInstanceByCode("delivery_services.zasilkovna.api_key");
			$sp->s("content","202913777c16fd80"); // snapps
		}
	}
}
