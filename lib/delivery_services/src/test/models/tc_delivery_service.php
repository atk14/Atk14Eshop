<?php
/**
 * @fixture delivery_services
 */
class TcDeliveryService extends TcBase {

	function test() {

		$this->assertFalse($this->delivery_services["zasilkovna"]->canBeUsed());
		$this->assertTrue($this->delivery_services["posta"]->canBeUsed());

		$this->assertEquals("https://www.zasilkovna.cz/api/v4/{API_KEY}/branch.xml", $this->delivery_services["zasilkovna"]->getBranchesDownloadUrl());
		$this->assertEquals("http://napostu.ceskaposta.cz/vystupy/napostu.xml", $this->delivery_services["posta"]->getBranchesDownloadUrl());

		$sys_param = SystemParameter::CreateNewRecord([
			"system_parameter_type_id" => 1,
			"code" => "delivery_services.zasilkovna.api_key",
			"name_cs" => "Zásilkovna API klíč",
			"content" => "",
			"mandatory" => false,
		]);

		$this->assertEquals("https://www.zasilkovna.cz/api/v4/{API_KEY}/branch.xml", $this->delivery_services["zasilkovna"]->getBranchesDownloadUrl());

		$sys_param->s("content", "abcdef0123456789");

		Cache::Clear();
		SystemParameter::ClearCache();
		$this->assertEquals("https://www.zasilkovna.cz/api/v4/abcdef0123456789/branch.xml", $this->delivery_services["zasilkovna"]->getBranchesDownloadUrl());
		$this->assertTrue($this->delivery_services["zasilkovna"]->canBeUsed());
	}
}
