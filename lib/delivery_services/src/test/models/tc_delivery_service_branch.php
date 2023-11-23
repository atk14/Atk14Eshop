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

	function test_branch_data_gls() {
		$xml_string = file_get_contents(__DIR__.'/data/gls.xml');;
		$xml = simplexml_load_string($xml_string, "DeliveryService\BranchParser\Gls");

		$nodes = $xml->xpath("//DropoffPoint");
		$node_0 = $nodes[0];
		$this->assertEquals("CZ10000-PARCELLOCK07", $node_0->getExternalBranchId());
		$this->assertEquals("AlzaBox P10 - Vršovice (Albert)", $node_0->getBranchName());
		$this->assertEquals("AlzaBox P10 - Vršovice (Albert)", $node_0->getPlaceName());
		$this->assertEquals("V Předpolí 279", $node_0->getFullAddress());
		$this->assertEquals("CZ", $node_0->getCountryCode());
		$this->assertEquals("10000", $node_0->getZipCode());
		$this->assertEquals("Praha 10", $node_0->getCity());
		$this->assertEquals("V Předpolí 279", $node_0->getStreet());
		$this->assertEquals("", $node_0->getInformationUrl());
#		$this->assertEquals("", $node_0->getOpeningHours());
		$this->assertEquals("50.0717", $node_0->getLatitude());
		$this->assertEquals("14.4826", $node_0->getLongitude());
		$this->assertTrue($node_0->isActive());
	}

	function test_branch_data_balikovna() {
		$xml_string = file_get_contents(__DIR__.'/data/balikovna.xml');;
		$xml = simplexml_load_string($xml_string, "DeliveryService\BranchParser\CpBalikovna");

		$xml->registerXPathNamespace("default", "http://www.cpost.cz/schema/aict/zv_2");
		$nodes = $xml->xpath("//default:row");
		$node_0 = $nodes[0];
		$this->assertEquals("10000", $node_0->getExternalBranchId());
		$this->assertEquals("Praha 10", $node_0->getBranchName());
		$this->assertEquals("Praha 10", $node_0->getPlaceName());
		$this->assertEquals("Černokostelecká 2020/20, Strašnice, 10000, Praha 10", $node_0->getFullAddress());
		$this->assertEquals("CZ", $node_0->getCountryCode());
		$this->assertEquals("10000", $node_0->getZipCode());
		$this->assertEquals("Praha 10", $node_0->getCity());
		$this->assertEquals("Černokostelecká 2020/20", $node_0->getStreet());
		$this->assertEquals("", $node_0->getInformationUrl());
#		$this->assertEquals("", $node_0->getOpeningHours());
		$this->assertEquals("", $node_0->getLatitude());
		$this->assertEquals("", $node_0->getLongitude());
		$this->assertTrue($node_0->isActive());
	}

	function test_branch_data_balik_na_postu() {
		$xml_string = file_get_contents(__DIR__.'/data/balik_na_postu.xml');;
		$xml = simplexml_load_string($xml_string, "DeliveryService\BranchParser\CpBalikNaPostu");

		$xml->registerXPathNamespace("default", "http://www.cpost.cz/schema/aict/zv");
		$nodes = $xml->xpath("//default:row");
		$node_0 = $nodes[0];
		$this->assertEquals("10004", $node_0->getExternalBranchId());
		$this->assertEquals("Praha 104", $node_0->getBranchName());
		$this->assertEquals("Praha 104", $node_0->getPlaceName());
		$this->assertEquals("Nákupní 389/3, Štěrboholy, 10004, Praha", $node_0->getFullAddress());
		$this->assertEquals("CZ", $node_0->getCountryCode());
		$this->assertEquals("10004", $node_0->getZipCode());
		$this->assertEquals("Praha", $node_0->getCity());
		$this->assertEquals("Nákupní 389/3", $node_0->getStreet());
		$this->assertEquals("", $node_0->getInformationUrl());
#		$this->assertEquals("", $node_0->getOpeningHours());
		$this->assertEquals("", $node_0->getLatitude());
		$this->assertEquals("", $node_0->getLongitude());
		$this->assertTrue($node_0->isActive());
	}

	function test_branch_data_zasilkovna() {
		$xml_string = file_get_contents(__DIR__.'/data/zasilkovna.xml');;
		$xml = simplexml_load_string($xml_string, "DeliveryService\BranchParser\Zasilkovna");

		$xml->registerXPathNamespace("default", "http://www.zasilkovna.cz/api/v4/branch");
		$nodes = $xml->xpath("//default:branch");
		$node_0 = $nodes[0];
		$this->assertEquals("46", $node_0->getExternalBranchId());
		$this->assertEquals("Brno, Královo Pole, Palackého tř. 48 (Mobilmax)", $node_0->getBranchName());
		$this->assertEquals("MobilMax", $node_0->getPlaceName());
		$this->assertEquals("Brno, Královo Pole, Palackého tř. 48 (Mobilmax)", $node_0->getFullAddress());
		$this->assertEquals("CZ", $node_0->getCountryCode());
		$this->assertEquals("61200", $node_0->getZipCode());
		$this->assertEquals("Brno", $node_0->getCity());
		$this->assertEquals("Palackého tř. 48", $node_0->getStreet());
		$this->assertEquals("https://www.zasilkovna.cz/pobocky/brno-kralovo-pole-palackeho-tr-mobil-max", $node_0->getInformationUrl());
#		$this->assertEquals("", $node_0->getOpeningHours());
		$this->assertEquals("49.22125", $node_0->getLatitude());
		$this->assertEquals("16.59668", $node_0->getLongitude());
		$this->assertTrue($node_0->isActive());
	}

	function test_branch_data_zasilkovna_inactive() {
		$xml_string = file_get_contents(__DIR__.'/data/zasilkovna_closed.xml');;
		$xml = simplexml_load_string($xml_string, "DeliveryService\BranchParser\Zasilkovna");

		$xml->registerXPathNamespace("default", "http://www.zasilkovna.cz/api/v4/branch");
		$nodes = $xml->xpath("//default:branch");
		$node_0 = $nodes[0];
		$this->assertFalse($node_0->isActive());
	}
}
