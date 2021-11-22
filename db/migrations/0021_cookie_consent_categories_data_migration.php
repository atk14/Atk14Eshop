<?php
// migration from package atk14/cookie-consent

class CookieConsentCategoriesDataMigration extends ApplicationMigration {

	function up(){
		if(TEST){ return; }

		CookieConsentCategory::CreateNewRecord([
			"id" => 1,
			"code" => "necessary",
			"necessary" => true,
			"active" => true,
			"title_en" => "Technical cookies",
			"title_cs" => "Technické cookies",
			"description_cs" => "Technické cookies jsou nezbytné pro správné fungování webu a všech funkcí, které nabízí. Jsou odpovědné mj. za uchovávání produktů v košíku, zobrazování seznamu oblíbených výrobků nebo nákupní proces. Používání technických cookies nemůže být zakázáno.",
			"description_en" => "Technical cookies are necessary for the proper functioning of the website and all the functions it offers. They are responsible for, among other things, storing products in the basket, displaying a list of favourites or the shopping process. The use of technical cookies cannot be prohibited.",
		]);

		CookieConsentCategory::CreateNewRecord([
			"id" => 2,
			"code" => "analytics",
			"active" => false,
			"cookies_regexp" => "/^(_ga.*|_gid.*|_utm.*)$/",
			"necessary" => false,
			"title_en" => "Analytic Cookies",
			"title_cs" => "Analytická cookies",
			"description_en" => "Analytical cookies allow us to measure the performance of our website and the effects of the adjustments we make to the website on an ongoing basis. We process the data obtained through these cookies in aggregate, without using identifiers that point to specific users of our website. If you disable the use of analytics cookies in relation to your visit, we lose the ability to analyse performance and optimise our measures.",
			"description_cs" => "Analytické cookies nám umožňují měření výkonu našeho webu a účinků úprav, které průběžně ne web nasazujeme. Data získaná pomocí těchto cookies zpracováváme souhrnně, bez použití identifikátorů, které ukazují na konkrétní uživatelé našeho webu. Pokud vypnete používání analytických cookies ve vztahu k Vaší návštěvě, ztrácíme možnost analýzy výkonu a optimalizace našich opatření.",
		]);

		CookieConsentCategory::CreateNewRecord([
			"id" => 3,
			"code" => "advertising",
			"active" => false,
			"cookies_regexp" => "/^(_fb)$/",
			"necessary" => false,
			"title_cs" => "Reklamní cookies",
			"title_en" => "Marketing & Advertising",
			"description_en" => "Advertising cookies allow us to show you relevant content or ads tailored to your interests both on our site and on third party sites.",
			"description_cs" => "Reklamní cookies nám umožňují zobrazovat Vám vhodný obsah nebo reklamy přizpůsobené Vašim zájmům jak na našich stránkách, tak na stránkách třetích subjektů.",
		]);
	}
}
