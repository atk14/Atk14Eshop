<?php
class TcSystemParameter extends TcBase {

	function test_name_delegation(){
		$sp_name = SystemParameter::CreateNewRecord([
			"code" => "testing.name",
			"system_parameter_type_id" => 1, // string
			"content" => "Test Name",
		],["use_cache" => true]);

		$sp_name_short = SystemParameter::CreateNewRecord([
			"code" => "testing.name.short",
			"system_parameter_type_id" => 1, // string
			"content" => null,
		],["use_cache" => true]);

		$this->assertEquals("Test Name",SystemParameter::ContentOn("testing.name"));
		$this->assertEquals("Test Name",SystemParameter::ContentOn("testing.name.short"));

		$sp_name_short->s("content","Short Name");

		$this->assertEquals("Test Name",SystemParameter::ContentOn("testing.name"));
		$this->assertEquals("Short Name",SystemParameter::ContentOn("testing.name.short"));
	}

	function test_automatic_cache_invalidation(){
		$this->assertEquals(null,SystemParameter::GetInstanceByCode("testing"));
		$this->assertEquals(null,SystemParameter::ContentOn("testing"));

		SystemParameter::CreateNewRecord([
			"code" => "testing",
			"system_parameter_type_id" => 1, // string
			"content" => "LaTesting",
		]);

		$sp = SystemParameter::GetInstanceByCode("testing");

		$this->assertTrue(is_object($sp));
		$this->assertEquals("LaTesting",SystemParameter::ContentOn("testing"));

		$sp->destroy();

		$this->assertEquals(null,SystemParameter::GetInstanceByCode("testing"));
		$this->assertEquals(null,SystemParameter::ContentOn("testing"));
	}
}
