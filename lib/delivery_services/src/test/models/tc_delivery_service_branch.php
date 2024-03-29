<?php
/**
 *
 * @fixture delivery_service_branches
 * @fixture delivery_services
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

	function test_getDeliveryAddressAr(){
		$posta_12000 = $this->delivery_service_branches["posta_12000"];

		$this->assertEquals([
			"delivery_company" => "Praha 2",
			"delivery_address_street" => "Moravská 1530/9",
			"delivery_address_street2" => null,
			"delivery_address_city" => "Praha",
			"delivery_address_state" => null,
			"delivery_address_zip" => "120 00",
			"delivery_address_country" => "CZ",
			"delivery_address_note" => null,
		],$posta_12000->getDeliveryAddressAr());
	}

	function test_getAddressStr(){
		$posta_12000 = $this->delivery_service_branches["posta_12000"];
		$this->assertEquals("120 00 Praha, Moravská 1530/9 - Praha 2",$posta_12000->getAddressStr());
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

	function test_parse_nodes() {
		$xml_string = file_get_contents(__DIR__.'/data/zasilkovna.xml');;
		$pc = $this->delivery_services["zasilkovna"]->getParserClass();
		$parser = $pc::GetInstance($xml_string);
		$nodes = $parser->_getBranchNodes();
		$this->assertCount(1, $nodes);

		$json_string = file_get_contents(__DIR__.'/data/ulozenka.json');;
		$pc = $this->delivery_services["wedo_ulozenka"]->getParserClass();
		$parser = $pc::GetInstance($json_string);
		$nodes = $parser->_getBranchNodes();
		$this->assertCount(5, $nodes);

		$xml_string = file_get_contents(__DIR__.'/data/balikovna.xml');;
		$parser = DeliveryService\BranchParser\CpBalikovna::GetInstance($xml_string);
		$nodes = $parser->_getBranchNodes();
		$this->assertCount(1, $nodes);

		$xml_string = file_get_contents(__DIR__.'/data/balik_na_postu.xml');;
		$parser = DeliveryService\BranchParser\CpBalikNaPostu::GetInstance($xml_string);
		$nodes = $parser->_getBranchNodes();
		$this->assertCount(1, $nodes);

		$xml_string = file_get_contents(__DIR__.'/data/gls.xml');;
		$parser = DeliveryService\BranchParser\Gls::GetInstance($xml_string);
		$nodes = $parser->_getBranchNodes();
		$this->assertCount(1, $nodes);
	}
}
