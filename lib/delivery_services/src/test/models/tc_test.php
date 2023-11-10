<?php

class TcTest extends TcBase {

	function test() {


		$content = file_get_contents(__DIR__."/data/ulozenka.json");
		$jse = new DeliveryService\BranchParser\WedoUlozenka($content);

		$el = $jse->_getBranchNodes()[0];

		error_log(print_r($el->getExternalBranchId(), true));
		error_log($el["country"]);
	}
}
