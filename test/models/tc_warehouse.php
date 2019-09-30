<?php
class TcWarehouse extends TcBase {

	function test_GetDefaultInstance4Eshop(){
		$w1 = Warehouse::CreateNewRecord([
			"applicable_to_eshop" => true,
		]);
		$w1->setRank(0);
		//
		$w = Warehouse::GetDefaultInstance4Eshop(["flush_cache" => true]);
		$this->assertEquals($w1->getId(),$w->getId());

		$w2 = Warehouse::CreateNewRecord([
			"applicable_to_eshop" => false,
		]);
		$w2->setRank(0);
		//
		$w = Warehouse::GetDefaultInstance4Eshop(["flush_cache" => true]);
		$this->assertEquals($w1->getId(),$w->getId());

		$w3 = Warehouse::CreateNewRecord([
			"applicable_to_eshop" => true,
		]);
		$w3->setRank(0);
		//
		$w = Warehouse::GetDefaultInstance4Eshop(["flush_cache" => true]);
		$this->assertEquals($w3->getId(),$w->getId());
	}
}
