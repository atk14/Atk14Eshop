<?php
/**
 * @fixture delivery_services
 */
class TcDeliveryService extends TcBase {

	function setUp() {
		parent::setUp();

		Cache::Clear();
		SystemParameter::ClearCache();
	}

	protected function _add_system_parameter_for_zasilkovna_api() {
		$zasilkovna_api_parameter = $this->zasilkovna_api_parameter = SystemParameter::CreateNewRecord([
			"system_parameter_type_id" => 1,
			"code" => "delivery_services.zasilkovna.api_key",
			"name_cs" => "Zásilkovna API klíč",
			"content" => "",
			"mandatory" => false,
		]);
		return $zasilkovna_api_parameter;;
	}

	function test_get_branches_url() {
		$this->delivery_services["posta"]->setParserClass("DeliveryService\BranchParser\CpBalikNaPostu");
		$this->assertEquals("https://www.zasilkovna.cz/api/v4/{API_KEY}/branch.xml", $this->delivery_services["zasilkovna"]->getBranchesDownloadUrl());
		$this->assertEquals("http://napostu.ceskaposta.cz/vystupy/napostu.xml", $this->delivery_services["posta"]->getBranchesDownloadUrl());

		$sys_param = $this->_add_system_parameter_for_zasilkovna_api();

		# bez api key vracime stale url s placeholderem
		$this->assertEquals("https://www.zasilkovna.cz/api/v4/{API_KEY}/branch.xml", $this->delivery_services["zasilkovna"]->getBranchesDownloadUrl());

		# se zadanym api key iz vracime kompletni url
		$sys_param->s("content", "abcdef0123456789");
		Cache::Clear();
		SystemParameter::ClearCache();
		$this->assertEquals("https://www.zasilkovna.cz/api/v4/abcdef0123456789/branch.xml", $this->delivery_services["zasilkovna"]->getBranchesDownloadUrl());
	}

	function test_can_be_used() {
		$this->delivery_services["posta"]->setParserClass("DeliveryService\BranchParser\CpBalikNaPostu");

		$this->assertFalse($this->delivery_services["zasilkovna"]->canBeUsed());
		$this->assertTrue($this->delivery_services["posta"]->canBeUsed());

		$sys_param = $this->_add_system_parameter_for_zasilkovna_api();

		$this->assertFalse($this->delivery_services["zasilkovna"]->canBeUsed());
		$sys_param->s("content", "abcdef0123456789");

		Cache::Clear();
		SystemParameter::ClearCache();
		$this->assertTrue($this->delivery_services["zasilkovna"]->canBeUsed());
	}
}
