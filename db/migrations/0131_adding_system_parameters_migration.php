<?php
class AddingSystemParametersMigration extends ApplicationMigration {
	
	/*
		app
			name
				official
				short
				yours
			motto
			email

		eshop
			default_currency
			default_region

		merchant
			billing_information
				company
				address_street
				address_street2
				address_city
				address_state
				address_zip
				address_country
				company_number
				vat_id
				vat_payer

		web
			theme

		email
			theme
				text_color
				link_color
				visited_link_color

		orders
			order_no_offset
			notifications
				shipping_days
				special_note

	 */

	function up(){
		$type = $this->dbmole->selectIntoAssociativeArray("SELECT code, id FROM system_parameter_types");

		SystemParameter::CreateNewRecord([
			"code" => "app.name",
			"system_parameter_type_id" => $type["localized_string"],
			"name_en" => "E-shop name",
			"name_cs" => "Název e-shopu",
			"mandatory" => true,
			"content_localized_cs" => "Obchůdek pana Broučka",
			"content_localized_en" => "Mr. Broucek's shop"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.name.short",
			"system_parameter_type_id" => $type["localized_string"],
			"name_en" => "E-shop name, shortened form",
			"name_cs" => "Název e-shopu, zkrácená verze",
			"mandatory" => false,
			"content_localized_cs" => "Pan Brouček",
			"content_localized_en" => "Mr. Broucek",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.name.official",
			"system_parameter_type_id" => $type["localized_string"],
			"name_en" => "E-shop name, official form",
			"name_cs" => "Název e-shopu, officiální",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.name.yours",
			"system_parameter_type_id" => $type["localized_string"],
			"name_en" => "E-shop name, in form Yours ...",
			"name_cs" => "Název e-shopu, ve formě Vaše ...",
			"mandatory" => false,
			"content_localized_cs" => "Váš Pan Brouček",
			"content_localized_en" => "Yours Mr. Broucek"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.motto",
			"system_parameter_type_id" => $type["localized_string"],
			"name_en" => "Motto",
			"name_cs" => "Motto",
			"mandatory" => false,
			"content_localized_cs" => "Přírodní produkty pro zdravější život",
			"content_localized_en" => "Natural products for a healthier life",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.bcc",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Email address for sending copy of all messages in hidden copy",
			"name_cs" => "E-mailová adresa pro zasílání kopii všech zpráv ve skryté kopii",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.contact.email",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Default email address",
			"name_cs" => "Výchozí e-mailová adresa",
			"mandatory" => true,
			"content" => "",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.contact.phone",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Phone number",
			"name_cs" => "Telefonní číslo",
			"mandatory" => false,
			"content" => "+420.605111222",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.site_verification.html_tag",
			"system_parameter_type_id" => $type["text"],
			"name_en" => "HTML tag for Google site verification",
			"description_en" => "One or more HTML meta tags for Google site verification",
			"name_cs" => "HTML tag pro Google site verification",
			"description_cs" => "Jeden nebo více HTML meta tagů pro Google site verification",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.analytics.tracking_id",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Google Analytics Tracking ID",
			"description_en" => "e.g. UA-000000-2",
			"name_cs" => "Google Analytics Tracking ID",
			"description_cs" => "např. UA-000000-2",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.tag_manager.container_id",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Google Tag Manager Container ID",
			"description_en" => "e.g. GTM-XXXX",
			"name_cs" => "Google Tag Manager Container ID",
			"description_cs" => "např. GTM-XXXX",
			"mandatory" => false,
		]);

		foreach([
			"facebook" => "facebook",
			"twitter" => "Twitter",
			"youtube" => "YouTube",
			"instagram" => "Instagram",
			"vimeo" => "Vimeo",
			"pinterest" => "Pinterest",
			"linkedin" => "LinkedIn",
			"snapchat" => "Snapchat"
		] as $key => $name){
			SystemParameter::CreateNewRecord([
				"code" => "app.contact.social.$key",
				"system_parameter_type_id" => $type["url"],
				"name_en" => $name,
				"name_cs" => $name,
				"mandatory" => false,
				"content" => null,
			]);
		}

		SystemParameter::CreateNewRecord([
			"code" => "eshop.default_currency",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Default currency code (e.g. CZK or EUR)",
			"name_cs" => "Kód výchozí měny (např. CZK nebo EUR)",
			"mandatory" => true,
			"read_only" => true,
			"content" => "CZK",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "eshop.default_region",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Default region (e.g. DEFAULT, CZ, SK or EU)",
			"name_cs" => "Kód výchozího regionu (např. DEFAULT, CZ, SK nebo EU)",
			"mandatory" => true,
			"read_only" => true,
			"content" => "DEFAULT",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.company",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Company name",
			"name_cs" => "Název firmy",
			"mandatory" => false,
			"content" => "Nanny and Dave e-Shop"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.name",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Name (if it's not a company)",
			"name_cs" => "Název (pokud se nejedná o firmu)",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.address.street",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Street",
			"name_cs" => "Ulice",
			"mandatory" => false,
			"content" => "Nerudova 22"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.address.street2",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Street (2nd line)",
			"name_cs" => "Ulice (2. řádek)",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.address.city",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "City",
			"name_cs" => "Město",
			"mandatory" => false,
			"content" => "Praha 1"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.address.state",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "State / Province / Region",
			"name_cs" => "Stát / provinice / kraj",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.address.zip",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "ZIP",
			"name_cs" => "PSČ",
			"mandatory" => false,
			"content" => "110 00"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.address.country",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Country code",
			"name_cs" => "Kód země",
			"mandatory" => false,
			"content" => "CZ",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.number",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank account number",
			"name_cs" => "Číslo bankovního účtu",
			"mandatory" => false,
			"content" => "11111111/2222",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.name",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "The name of the bank where the account is held",
			"name_cs" => "Název banky, u které je účet veden",
			"mandatory" => false,
			"content" => "Best Savings Bank",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.address.street",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank address: Street (Bank)",
			"name_cs" => "Adresa banky: Ulice (banka)",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.address.street2",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank address: Street (2nd line)",
			"name_cs" => "Adresa banky: Ulice (2. řádek)",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.address.city",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank address: City (Bank)",
			"name_cs" => "Adresa banky: Město",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.address.state",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank address: State / Province / Region",
			"name_cs" => "Adresa banky: Stát / provinice / kraj",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.address.zip",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank address: ZIP",
			"name_cs" => "Adresa banky: PSČ",
			"mandatory" => false,
			"content" => null
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.bank.address.country",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank address: Country code",
			"name_cs" => "Adresa banky: Kód země",
			"mandatory" => false,
			"content" => null,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.iban",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "IBAN",
			"name_cs" => "IBAN",
			"mandatory" => false,
			"content" => null,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.swift_bic",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "SWIFT/BIC",
			"name_cs" => "SWIFT/BIC",
			"mandatory" => false,
			"content" => null,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.bank_account.holder",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Bank account holder",
			"name_cs" => "Majitel bankovního účtu",
			"mandatory" => false,
			"content" => "Nanny and Dave e-Shop",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.company_number",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Company number",
			"name_cs" => "IČ",
			"mandatory" => false,
			"content" => "12345678"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.billing_information.vat_id",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "VAT ID",
			"name_cs" => "DIČ",
			"mandatory" => false,
			"content" => "CZ12345678"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "merchant.vat_payer",
			"system_parameter_type_id" => $type["boolean"],
			"name_en" => "VAT payer?",
			"name_cs" => "Plátce DPH?",
			"mandatory" => true,
			"read_only" => true,
			"content" => "TRUE",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "orders.order_no_offset",
			"system_parameter_type_id" => $type["integer"],
			"name_en" => "",
			"name_cs" => "Offset čísla objednávky",
			"description_cs" => "Číslo, které bude přičteno k postupně rostoucí číselné hodnotě pro stanovení konečného čísla každé nové objednávky.",
			"mandatory" => true,
			"content" => "12000"
		]);

		SystemParameter::CreateNewRecord([
			"code" => "orders.notifications.shipping_days",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Usual number of days for order delivery",
			"name_cs" => "Obvyklý počet dnů pro doručení objednávky",
			"content" => "1-2",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "orders.notifications.special_note",
			"system_parameter_type_id" => $type["localized_text"],
			"name_en" => "Extra note in email order recap",
			"description_en" => "Do not use HTML tags. New lines will be converted to ```<br/>``` automatically.",
			"name_cs" => "Mimořádna poznámka v e-mailové rekapitulaci objednávky",
			"description_cs" => "Nepoužívejte HTML značky. Nové řádky budou převedeny na ```<br/>``` automaticky.",
		]);
	}
}
