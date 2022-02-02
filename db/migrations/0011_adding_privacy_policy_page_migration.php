<?php
class AddingPrivacyPolicyPageMigration extends ApplicationMigration {

	function up(){
		if(Page::FindByCode("privacy_policy")){
			return;
		}

		$url = [];
		foreach(["en","cs"] as $lang){
			$url[$lang] = Atk14Url::BuildLink([
				"namespace" => "",
				"controller" => "cookie_consents",
				"action" => "edit",
				"lang" => $lang,
			]);
		}

		$page = Page::CreateNewRecord([
			"code" => "privacy_policy",

			"title_en" => "Privacy Policy",
			"title_cs" => "Ochrana osobních údajů",

			"body_en" => trim("
### Cookies {#cookies}

You can customize the use of cookies based on your preferences on the [Cookie Settings page]($url[en]).
			"),
			"body_cs" => trim("
### Cookies {#cookies}

Používání cookies na základě vlastních preferencí si můžete upravit na stránce [Nastavení cookies]($url[cs]).
			"),
		]);
	}
}
