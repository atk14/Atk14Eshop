<?php
class AddingPrivacyPolicyPageMigration extends ApplicationMigration {

	function up(){
		$page = Page::CreateNewRecord([
			"code" => "privacy_policy",
			
			"title_en" => "Privacy Policy",

			"title_cs" => "Ochrana osobních údajů",
		]);
	}
}
