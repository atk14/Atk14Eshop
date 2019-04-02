<?php
class TcRegion extends TcBase {

	function test(){
		$region = Region::CreateNewRecord([
			"code" => "TEST",
		]);
		//
		$this->assertEquals(ATK14_APPLICATION_NAME,$region->getApplicationName());
		$this->assertEquals(ATK14_APPLICATION_NAME,$region->getApplicationLongName());
		$this->assertEquals(DEFAULT_EMAIL,$region->getEmail());

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
