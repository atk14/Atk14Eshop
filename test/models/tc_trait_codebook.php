<?php
/**
 *
 * @fixture delivery_methods
 */
class TcTraitCodebook extends TcBase {

	function test(){
		$cnt_1 = $this->dbmole->getQueriesExecuted();

		$dpd = DeliveryMethod::GetInstanceByCode("dpd_test");
		$this->assertEquals("dpd_test",$dpd->getCode());
		$dpd = DeliveryMethod::FindByCode("dpd_test");
		$this->assertEquals("dpd_test",$dpd->getCode());
		$this->assertNull(DeliveryMethod::FindByCode("nonexistent"));
		$dpd = DeliveryMethod::GetInstanceById($this->delivery_methods["dpd"]->getId());
		$this->assertEquals("dpd_test",$dpd->getCode());
		$this->assertNull(DeliveryMethod::GetInstanceById(-123));

		$cnt_2 = $this->dbmole->getQueriesExecuted();

		$dpd = DeliveryMethod::GetInstanceByCode("dpd_test");
		$this->assertEquals("dpd_test",$dpd->getCode());
		$dpd = DeliveryMethod::FindByCode("dpd_test");
		$this->assertEquals("dpd_test",$dpd->getCode());
		$this->assertNull(DeliveryMethod::FindByCode("nonexistent"));
		$dpd = DeliveryMethod::GetInstanceById($this->delivery_methods["dpd"]->getId());
		$this->assertEquals("dpd_test",$dpd->getCode());
		$this->assertNull(DeliveryMethod::GetInstanceById(-123));

		$cnt_3 = $this->dbmole->getQueriesExecuted();

		$this->assertEquals($cnt_2,$cnt_1+2);
		$this->assertEquals($cnt_2,$cnt_3);
	}
}
