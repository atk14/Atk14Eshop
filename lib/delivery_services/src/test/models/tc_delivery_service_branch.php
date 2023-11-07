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
		$xml_string = '<?xml version="1.0" encoding="UTF-8"?><DropoffData xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><CtrCode>CZ</CtrCode><Updated>2023-11-07T10:41:07</Updated>
<Data>
<DropoffPoint ID="CZ10000-PARCELLOCK07" Name="AlzaBox P10 - Vršovice (Albert)" Address="V Předpolí 279" CtrCode="CZ" ZipCode="10000" CityName="Praha 10" Contact="" ContactPhone="" IsCODHandler="1" IsParcelLocker="1" GeoLat="50.0717" GeoLng="14.4826" >
<Openings>
  <Openings Day="Monday" OpenHours="00:00-24:00" MidBreak="" />
  <Openings Day="Tuesday" OpenHours="00:00-24:00" MidBreak="" />
  <Openings Day="Wednesday" OpenHours="00:00-24:00" MidBreak="" />
  <Openings Day="Thursday" OpenHours="00:00-24:00" MidBreak="" />
  <Openings Day="Friday" OpenHours="00:00-24:00" MidBreak="" />
  <Openings Day="Saturday" OpenHours="00:00-24:00" MidBreak="" />
  <Openings Day="Sunday" OpenHours="00:00-24:00" MidBreak="" />
</Openings>
</DropoffPoint>
</Data></DropoffData>
';
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
	}

	function test_branch_data_balikovna() {
		$xml_string = '<?xml version="1.0" encoding="UTF-8"?><zv xmlns="http://www.cpost.cz/schema/aict/zv_2" xmlns:xsi="http://www.cpost.cz/schema/aict/zv_2" xsi:schemaLocation="http://www.cpost.cz/schema/aict/zv_2">
<row>
        <PSC>10000</PSC>
        <NAZEV>Praha 10</NAZEV>
        <ADRESA>Černokostelecká 2020/20, Strašnice, 10000, Praha 10</ADRESA>
        <TYP>pošta</TYP>
        <OTEV_DOBY>
            <den name="Pondělí">
                <od_do>
                    <od>08:00</od>
                    <do>19:30</do>
                </od_do>
            </den>
            <den name="Úterý">
                <od_do>
                    <od>08:00</od>
                    <do>19:30</do>
                </od_do>
            </den>
            <den name="Středa">
                <od_do>
                    <od>08:00</od>
                    <do>19:30</do>
                </od_do>
            </den>
            <den name="Čtvrtek">
                <od_do>
                    <od>08:00</od>
                    <do>19:30</do>
                </od_do>
            </den>
            <den name="Pátek">
                <od_do>
                    <od>08:00</od>
                    <do>19:30</do>
                </od_do>
            </den>
            <den name="Sobota">
                <od_do>
                    <od>09:00</od>
                    <do>13:00</do>
                </od_do>
            </den>
            <den name="Neděle"/>
        </OTEV_DOBY>
        <SOUR_X>1044922.91</SOUR_X>
        <SOUR_Y>737904.98</SOUR_Y>
        <OBEC>Praha</OBEC>
        <C_OBCE>Strašnice</C_OBCE>
        <SOUR_X_WGS84>14.492777</SOUR_X_WGS84>
        <SOUR_Y_WGS84>50.076442</SOUR_Y_WGS84>
        <STAV/>
        <POPIS/>
        <PRIJEM_NR>A</PRIJEM_NR>
        <TISK_STITKU>N</TISK_STITKU>
    </row>
</zv>';
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
	}

	function test_branch_data_balik_na_postu() {
		$xml_string = '<?xml version="1.0" encoding="UTF-8"?>
<zv xmlns="http://www.cpost.cz/schema/aict/zv" xmlns:xsi="http://www.cpost.cz/schema/aict/zv" xsi:schemaLocation="http://www.cpost.cz/schema/aict/zv">
<row>
        <PSC>10004</PSC>
        <NAZ_PROV>Praha 104</NAZ_PROV>
        <OKRES>Hlavní město Praha</OKRES>
        <ADRESA>Nákupní 389/3, Štěrboholy, 10004, Praha</ADRESA>
        <V_PROVOZU>N</V_PROVOZU>
        <PRODL_DOBA>A</PRODL_DOBA>
        <BANKOMAT>N</BANKOMAT>
        <PARKOVISTE>A</PARKOVISTE>
        <KOMPLET_SERVIS>A</KOMPLET_SERVIS>
        <VIKEND>A</VIKEND>
        <LOKALITY_PRODL>N</LOKALITY_PRODL>
        <VYDEJ_NP_OD/>
        <UKL_NP_LIMIT>A</UKL_NP_LIMIT>
        <PSC_NP_NAHR/>
        <NAZ_NP_NAHR/>
        <ABC_BOX>N</ABC_BOX>
        <OTV_DOBA>
            <den name="Pondělí">
                <od_do>
                    <od>09:00</od>
                    <do>19:00</do>
                </od_do>
            </den>
            <den name="Úterý">
                <od_do>
                    <od>09:00</od>
                    <do>19:00</do>
                </od_do>
            </den>
            <den name="Středa">
                <od_do>
                    <od>09:00</od>
                    <do>19:00</do>
                </od_do>
            </den>
            <den name="Čtvrtek">
                <od_do>
                    <od>09:00</od>
                    <do>19:00</do>
                </od_do>
            </den>
            <den name="Pátek">
                <od_do>
                    <od>09:00</od>
                    <do>19:00</do>
                </od_do>
            </den>
            <den name="Sobota">
                <od_do>
                    <od>09:00</od>
                    <do>18:00</do>
                </od_do>
            </den>
            <den name="Neděle">
                <od_do>
                    <od>09:00</od>
                    <do>18:00</do>
                </od_do>
            </den>
        </OTV_DOBA>
        <SOUR_X>1045845</SOUR_X>
        <SOUR_Y>734386.14</SOUR_Y>
        <SOUR_X_WGS84>14.543227</SOUR_X_WGS84>
        <SOUR_Y_WGS84>50.072500</SOUR_Y_WGS84>
    </row>
</zv>';
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
	}
	function test_branch_data_zasilkovna() {
		$xml_string = '<?xml version="1.0" encoding="UTF-8" ?>
<export xmlns="http://www.zasilkovna.cz/api/v4/branch"
                xmlns:ns="http://www.zasilkovna.cz/api/v4/branch"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation="http://www.zasilkovna.cz/api/v4/branch http://www.zasilkovna.cz/api/v4/branch.xsd">
        <contacts>
<contact>
        <country>cs</country>
        <phone>+420 216 216 516</phone>
        <email>info@zasilkovna.cz</email>
        <businessHours>Po-Pá 08:00-18:00</businessHours>
</contact>
</contacts>
<branches>
  <branch>
        <id>46</id>
        <name>Brno, Královo Pole, Palackého tř. 48 (Mobilmax)</name>
        <place>MobilMax</place>
        <street>Palackého tř. 48</street>
        <city>Brno</city>
        <zip>612 00</zip>
        <country>cz</country>
        <currency>CZK</currency>
        <status>
                <statusId>1</statusId>
                <description>V provozu</description>
        </status>
        <displayFrontend>1</displayFrontend>
        <directions>&lt;p&gt;Výdejní místo se nachází na nejfrekventovanější ulici Palackého třída městské části Královo Pole po pravé straně směrem z města u zastávky tramvaje Jungmannova. Směrem do centra je provozovna přímo naproti zastávce. V opačném směru je ze zastávky potřeba ujít cca 25 metrů. Možnost parkování je hned před prodejnou. V případě obsazení je v okolí další spousta parkovacích míst.  &lt;/p&gt;</directions>
        <directionsCar></directionsCar>
        <directionsPublic>&lt;p&gt; stanice Jungmannova: tramvaje č. 1, 6&lt;/p&gt;</directionsPublic>
        <wheelchairAccessible>no</wheelchairAccessible>
        <creditCardPayment>yes</creditCardPayment>
        <dressingRoom>0</dressingRoom>
        <claimAssistant>1</claimAssistant>
        <packetConsignment>1</packetConsignment>
        <latitude>49.22125</latitude>
        <longitude>16.59668</longitude>
        <url>https://www.zasilkovna.cz/pobocky/brno-kralovo-pole-palackeho-tr-mobil-max</url>
        <maxWeight>5</maxWeight>
        <labelRouting>C67-202-046</labelRouting>
        <labelName>Brno, Královo Pole, Palackého tř., MobilMax</labelName>
        <photos>
                        <photo>
                                <thumbnail>https://files.packeta.com/points/thumb/IMG_9578.jpg</thumbnail>
                                <normal>https://files.packeta.com/points/normal/IMG_9578.jpg</normal>
                        </photo>
                        <photo>
                                <thumbnail>https://files.packeta.com/points/thumb/IMG_9580.jpg</thumbnail>
                                <normal>https://files.packeta.com/points/normal/IMG_9580.jpg</normal>
                        </photo>
        </photos>
        <openingHours>
                <regular>
                                <monday>08:00–17:30</monday>
                                <tuesday>08:00–17:30</tuesday>
                                <wednesday>08:00–17:30</wednesday>
                                <thursday>08:00–17:30</thursday>
                                <friday>08:00–17:30</friday>
                                <saturday>09:00–12:00</saturday>
                                <sunday></sunday>
                </regular>
                <exceptions>
                                <exception>
                                        <date>2023-11-17</date>
                                        <hours></hours>
                                </exception>
                                <exception>
                                        <date>2023-11-18</date>
                                        <hours></hours>
                                </exception>
                                <exception>
                                        <date>2023-11-19</date>
                                        <hours></hours>
                                </exception>
                </exceptions>
        </openingHours>
  </branch>
</branches>
</export>
';
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
	}
}
