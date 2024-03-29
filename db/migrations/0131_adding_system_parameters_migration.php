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
			"name_en" => "Email address (or addresses) for sending copy of all messages in hidden copy",
			"name_cs" => "E-mailová adresa (nebo adresy) pro zasílání kopii všech zpráv ve skryté kopii",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.contact.email",
			"system_parameter_type_id" => $type["email"],
			"name_en" => "Default email address",
			"name_cs" => "Výchozí e-mailová adresa",
			"mandatory" => true,
			"content" => "",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.contact.phone",
			"system_parameter_type_id" => $type["phone"],
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
			"description_en" => "Tracking code will be inserted using Global Site Tag (gtag.js). You can insert multiple tracking ids separated with comma, semicolon, space. E.g. 'UA-000000-2,UA-000000-3;UA-000000-4'",
			"name_cs" => "Google Analytics Tracking ID",
			"description_cs" => "Při zadání ID měření bude vložen měřící kód pomocí globální webové značky (gtag.js). Můžete vložit více ID oddělených čárkou, středníkem, mezerou. Např. 'UA-000000-2,UA-000000-3;UA-000000-4'",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.tag_manager.container_id",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Google Tag Manager Container ID",
			"description_en" => "e.g. GTM-XXXX. Standard Javascript code will be generated to load GTM script",
			"name_cs" => "Google Tag Manager Container ID",
			"description_cs" => "např. GTM-XXXX. Vygeneruje se standardní Javascriptový kód pro nahrání GTM skriptu",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.tag_manager.custom_code.head",
			"system_parameter_type_id" => $type["text"],
			"name_en" => "Google Tag Manager Custom Code for <head> section",
			"description_en" => "Custom snippet of code to load GTM script. It can include special instruction, e.g. for using a different GTM environment.<br>Usually is not necessary and it is enouch to set only the <b>container_id</b>.",
			"name_cs" => "Google Tag Manager - vlastní kód pro <head> část",
			"description_cs" => "Vlastní kód pro vložení GTM skriptu. Může obsahovat zvláštní instrukce, například pro použití jiného GTM prostředí.<br>Obvykle není potřeba a stačí nastavit pouze <b>container_id</b>",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.google.tag_manager.custom_code.body",
			"system_parameter_type_id" => $type["text"],
			"name_en" => "Google Tag Manager Custom Code for <body> section",
			"description_en" => "Custom snippet of code to load GTM script. It can include special instruction, e.g. for using a different GTM environment.<br>Usually is not necessary and it is enouch to set only the <b>container_id</b>.",
			"name_cs" => "Google Tag Manager - vlastní kód pro <body> část",
			"description_cs" => "Vlastní kód pro vložení GTM skriptu. Může obsahovat zvláštní instrukce, například pro použití jiného GTM prostředí.<br>Obvykle není potřeba a stačí nastavit pouze <b>container_id</b>",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.facebook.pixel.tracking_id",
			"system_parameter_type_id" => $type["string"],
			"name_en" => "Facebook Pixel ID",
			"description_en" => "Pixel's id to install base code for tracking user'a activities on your web",
			"name_cs" => "Facebook Pixel ID",
			"description_cs" => "Identifikátor pixelu pro vytvoření základního kódu pro sledování aktivit uživatele na vašem webu",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.trackers.facebook.site_verification.html_tag",
			"system_parameter_type_id" => $type["text"],
			"name_en" => "HTML tag for Facebook domain verification",
			"description_en" => "One or more HTML meta tags for Facebook domain verification",
			"name_cs" => "HTML tag pro Facebook domain verification",
			"description_cs" => "Jeden nebo více HTML meta tagů pro Facebook domain verification",
			"mandatory" => false,
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.social.default_image",
			"system_parameter_type_id" => $type["image_url"],
			"name_en" => "Default image for social media sharing",
			"description_en" => "Large enough JPG image",
			"name_cs" => "Výchozí obrázek pro sdílení na sociálních médiích",
			"description_cs" => "Dostatečně velký obrázek ve formátu JPG",
			"mandatory" => false,
			"content" => "https://i.pupiq.net/i/65/65/6b9/2d6b9/626x417/4dOoGF_626x417_55489d650c7f8c91.jpg",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.favicon",
			"system_parameter_type_id" => $type["image_url"],
			"name_en" => "Favicon",
			"description_en" => "A square PNG image of at least 800x800 pixels is recommended. Transparency is supported.",
			"name_cs" => "Favicon",
			"description_cs" => "Doporučen je čtvercový obrázek ve formátu PNG o velikosti alespoň 800x800 bodů. Průhlednost je podporována.",
			"mandatory" => false,
			"content" => "https://i.pupiq.net/i/65/65/6b8/2d6b8/1200x1200/BmlcpL_800x800_4b4bad2fa33a95c0.png",
		]);

		SystemParameter::CreateNewRecord([
			"code" => "app.favicon.small",
			"system_parameter_type_id" => $type["image_url"],
			"name_en" => "Small favicon",
			"description_en" => "Image of the favicon for display in small dimensions. A square PNG image is recommended. Transparency is supported.",
			"name_cs" => "Malá favicon",
			"description_cs" => "Obrázek favicony pro zobrazení v malých rozměrech. Doporučen je čtvercový obrázek ve formátu PNG. Průhlednost je podporována.",
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
			"snapchat" => "Snapchat",
			"soundcloud" => "SoundCloud",
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
