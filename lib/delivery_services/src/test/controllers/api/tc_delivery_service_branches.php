<?php
/**
 *
 * @fixture delivery_services
 * @fixture delivery_service_branches
 */
class TcDeliveryServiceBranches extends TcBase {

	function test_CzechPost() {
		$suggestions = $this->_get("delivery_service_branches/index", [
			"delivery_service_id" => $this->delivery_services["posta"],
			"format" => "json",
			"q" => "120",
		]);
		$this->assertEquals(200,$this->_getLastStatusCode());

		$this->assertCount(1, $suggestions);
		$sug = array_shift($suggestions);
		$this->assertArrayHasKey("value", $sug);
		$this->assertArrayHasKey("label", $sug);
		$this->assertArrayHasKey("opening_hours", $sug);

		$this->assertEquals("12000", $sug["value"]);
		$this->assertEquals("12000, Moravská 1530/9, Vinohrady, 12000, Praha - Praha 2", $sug["label"]);
		$this->assertEquals("", $sug["opening_hours"]);

		# hledani podle 'place' nebo 'name'
		$suggestions = $this->_get("delivery_service_branches/index", [
			"delivery_service_id" => $this->delivery_services["posta"],
			"format" => "json",
			"q" => "praha 3",
		]);
		$this->assertEquals(200,$this->_getLastStatusCode());

		$this->assertCount(1, $suggestions);
		$sug = array_shift($suggestions);
		$this->assertArrayHasKey("value", $sug);
		$this->assertArrayHasKey("label", $sug);
		$this->assertArrayHasKey("opening_hours", $sug);

		$this->assertEquals("13000", $sug["value"]);
		$this->assertEquals("13000, Olšanská 38/9, Žižkov, 13000, Praha - Praha 3", $sug["label"]);
		$this->assertEquals("", $sug["opening_hours"]);

	}

	function test_Packeta(){
		$suggestions = $this->_get("delivery_service_branches/index", [
			"delivery_service_id" => $this->delivery_services["zasilkovna"],
			"format" => "json",
			"q" => "120",
		]);
		$this->assertEquals(200,$this->_getLastStatusCode());
		$this->assertCount(0, $suggestions);

		# hledani podle 'zip'
		$suggestions = $this->_get("delivery_service_branches/index", [
			"delivery_service_id" => $this->delivery_services["zasilkovna"],
			"format" => "json",
			"q" => "123",
		]);
		$this->assertCount(2, $suggestions);

		$values = array_column($suggestions, "value");
		$this->assertEquals(["1","2"], $values);

		# hledani podle nazvu 'name'
		$suggestions = $this->_get("delivery_service_branches/index", [
			"delivery_service_id" => $this->delivery_services["zasilkovna"],
			"format" => "json",
			"q" => "první",
		]);
		$this->assertEquals(200,$this->_getLastStatusCode());

		$this->assertCount(1, $suggestions);
	}
}
