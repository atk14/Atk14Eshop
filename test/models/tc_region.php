<?php
/**
 *
 * @fixture regions
 */
class TcRegion extends TcBase {

	function test(){
		foreach(["app.contact.email","app.name","app.name.short"] as $code){
			if($sp = SystemParameter::GetInstanceByCode($code)){
				$sp->destroy();
			}
		}

		$region = Region::CreateNewRecord([
			"code" => "TEST",
			"languages" => '["cs","en"]',
		]);
		//
		$this->assertEquals(ATK14_APPLICATION_NAME,$region->getApplicationName());
		$this->assertEquals(ATK14_APPLICATION_NAME,$region->getApplicationLongName());
		$this->assertEquals(DEFAULT_EMAIL,$region->getEmail());

		// testing Region::getLanguages()
		$langs = $region->getLanguages();
		$this->assertEquals(2,sizeof($langs));
		$this->assertEquals("cs",$langs[0]->getId());
		$this->assertEquals("en",$langs[1]->getId());
		//
		$langs = $region->getLanguages(array("as_objects" => true));
		$this->assertEquals(array("cs","en"),$langs);

		foreach(["app.contact.email" => "john@test.com","app.name" => "TEST LONG NAME","app.name.short" => "TEST NAME"] as $code => $content){
			SystemParameter::CreateNewRecord([
				"code" => $code,
				"system_parameter_type_id" => SystemParameterType::FindByCode("string"),
				"content" => $content,
			]);
		}
		//
		$this->assertEquals("TEST NAME",$region->getApplicationName());
		$this->assertEquals("TEST LONG NAME",$region->getApplicationLongName());
		$this->assertEquals("john@test.com",$region->getEmail());

		$region->s([
			"application_name_en" => "Test_name",
			"application_name_cs" => "Test_name",

			"application_long_name_en" => "Test_long_name",
			"application_long_name_cs" => "Test_long_name",

			"email" => "test@email.com",
		]);
		//
		$this->assertEquals("Test_name",$region->getApplicationName());
		$this->assertEquals("Test_long_name",$region->getApplicationLongName());
		$this->assertEquals("test@email.com",$region->getEmail());
	}

	function test_GetCountries(){
		$default = Region::GetInstanceByCode("DEFAULT");
		$default->s("invoice_countries",'["CZ"]');
		Cache::Clear();

		// delivery
		$countries = Region::GetDeliveryCountriesFromAllRegions();
		$this->assertEquals(["CZ","SK","DE","AT","HU","PL","BE","FR","NL","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"],$countries);
		$countries = Region::GetDeliveryCountriesFromActiveRegions();
		$this->assertEquals(["CZ","SK","DE","AT","HU","PL","BE","FR","NL","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"],$countries);

		// invoice
		$countries = Region::GetInvoiceCountriesFromAllRegions();
		$this->assertEquals(["CZ","SK","DE","AT","HU","PL","BE","FR","NL","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"],$countries);
		$countries = Region::GetInvoiceCountriesFromActiveRegions();
		$this->assertEquals(["CZ","SK","DE","AT","HU","PL","BE","FR","NL","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"],$countries);


		$this->regions["EU"]->s("active",false);
		Cache::Clear();

		// delivery
		$countries = Region::GetDeliveryCountriesFromAllRegions();
		$this->assertEquals(["CZ","SK","DE","AT","HU","PL","BE","FR","NL","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"],$countries);
		$countries = Region::GetDeliveryCountriesFromActiveRegions();
		$this->assertEquals(["CZ","SK"],$countries);

		// invoice
		$countries = Region::GetInvoiceCountriesFromAllRegions();
		$this->assertEquals(["CZ","SK","DE","AT","HU","PL","BE","FR","NL","EE","IT","LV","LT","IE","SI","BG","FI","RO","SE","PT","ES","DK","GR"],$countries);
		$countries = Region::GetInvoiceCountriesFromActiveRegions();
		$this->assertEquals(["CZ","SK"],$countries);

		$this->regions["EU"]->s("invoice_countries",null); // no limit
		Cache::Clear();

		$countries = Region::GetInvoiceCountriesFromAllRegions();
		$this->assertEquals(null,$countries);

		$countries = Region::GetInvoiceCountriesFromActiveRegions();
		$this->assertEquals(["CZ","SK"],$countries);

		$this->regions["CR"]->s("invoice_countries",null); // no limit
		Cache::Clear();

		$countries = Region::GetInvoiceCountriesFromActiveRegions();
		$this->assertEquals(null,$countries);
	}

	function test_GetDefaultValueForRegionsColumn(){
		$this->assertEquals('{"DEFAULT":true,"CZECHOSLOVAKIA":true,"CR":true,"SK":true,"EU":true}',Region::GetDefaultValueForRegionsColumn());
	}

	function test_getShortName(){
		$this->assertEquals("CSK",$this->regions["czechoslovakia"]->getShortName());
		$this->assertEquals("ČSR",$this->regions["czechoslovakia"]->getShortName("cs"));
		$this->assertEquals("CSK",$this->regions["czechoslovakia"]->getShortName("en"));

		$this->regions["czechoslovakia"]->s([
			"short_name_cs" => null,
			"short_name_en" => null,
		]);

		$this->assertEquals("Czechoslovakia",$this->regions["czechoslovakia"]->getShortName());
		$this->assertEquals("Československo",$this->regions["czechoslovakia"]->getShortName("cs"));
		$this->assertEquals("Czechoslovakia",$this->regions["czechoslovakia"]->getShortName("en"));
	}

	function test_getShortcut(){
		$region = Region::CreateNewRecord([
			"code" => "NEVER",
			"name_en" => "Neverland",
			"name_cs" => "Nikdosvět",
		]);
		$this->assertEquals("NEV",$region->getShortcut());
		$this->assertEquals("NIK",$region->getShortcut("cs"));

		$region->s([
			"short_name_en" => "Neve",
			"short_name_cs" => "Nikd",
		]);
		$this->assertEquals("Neve",$region->getShortcut());
		$this->assertEquals("Nikd",$region->getShortcut("cs"));
	}
}
