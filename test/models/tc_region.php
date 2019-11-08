<?php
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
}
