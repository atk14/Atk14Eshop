<?php
/**
 *
 * @fixture delivery_addresses
 */
class TcDeliveryAddress extends TcBase {

	function test_toExportArray(){
		$da = $this->delivery_addresses["kveta_doma"];
		$ary = $da->toExportArray();

		$this->assertEquals("+420 605 123 456",$ary["phone"]);
		$this->assertEquals([
			"id",
			"firstname",
			"lastname",
			"company",
			"address_street",
			"address_street2",
			"address_city",
			"address_state",
			"address_zip",
			"address_country",
			"address_note",
			"phone",
		],array_keys($ary));
	}
}
