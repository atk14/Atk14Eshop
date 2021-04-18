<?php
/**
 *
 * @fixture delivery_service_branches
 */
class TcDeliveryServiceBranch extends TcBase {

	function test(){
		$dsb = $this->delivery_service_branches["zasilkovna_1"];

		$json = $dsb->getDeliveryMethodData();
		$this->assertTrue(is_string($json));
		//
		$json = $dsb->getDeliveryMethodData(["as_json" => true]);
		$this->assertTrue(is_string($json));
		//
		$json = $dsb->getDeliveryMethodData(true);
		$this->assertTrue(is_string($json));

		$data = $dsb->getDeliveryMethodData(["as_json" => false]);
		$this->assertTrue(is_array($data));
		//
		$this->assertEquals($data,json_decode($json,true));
	}
}
