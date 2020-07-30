<?php
namespace DeliveryService\BranchParser;
require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

class CpBalikNaPostu extends DeliveryServiceBranchData implements iDeliveryServiceBranchParser {

	static $BRANCHES_DOWNLOAD_URL = "http://napostu.ceskaposta.cz/vystupy/napostu.xml";

	function getExternalBranchId() {
		return trim((string)$this->branch_element->PSC);
	}

	function getBranchName() {
		return trim((string)$this->branch_element->NAZ_PROV);
	}

	function getPlaceName() {
		return trim((string)$this->branch_element->NAZ_PROV);
	}

	function getFullAddress() {
		return trim((string)$this->branch_element->ADRESA);
	}

	function getCountryCode() {
		return "CZ";
	}

	function getDistrict() {
		return trim((string)$this->branch_element->OKRES);
	}

	function getZipCode() {
		return  trim((string)$this->branch_element->PSC);
	}

	private function _parseAddress() {
		$address = explode(",", (string)$this->branch_element->ADRESA);

		$city = array_pop($address);
		$zip = array_pop($address);
		$city_part = array_pop($address);
		$street = array_pop($address);
		if (is_null($street)) {
			$street = $city_part;
			$city_part = "";
		}
		return [
			"city" => trim($city),
			"zip" => trim($zip),
			"street" => trim($street),
			"city_part" => trim($city_part),
		];
	}

	function getCity() {
		$_address = $this->_parseAddress();
		return $_address["city"];
	}

	function getStreet() {
		$_address = $this->_parseAddress();
		return $_address["street"];
	}

	function getInformationUrl() {
		return null;
	}

	function getLatitude() {
		return null;
	}

	function getLongitude() {
		return null;
	}

	function getOpeningHours() {
		$_openHoursAr = array();
		foreach($this->branch_element->OTV_DOBA->den as $den) {
			$_ohDay = array(
				"day_name" => (string)$den["name"],
				"hours" => array(),
			);
			foreach($den->od_do as $_od_do) {
				$_ohDay["hours"][] = array(
					"open_from" => (string)$_od_do->od,
					"open_to" => (string)$_od_do->do,
				);
			}
			$_openHoursAr[] = $_ohDay;
		}
		return $_openHoursAr;

	}

	static function ParseBranch(\SimpleXMLElement $element) {
		$branch_element = new static($element);

		return [
			"external_branch_id" => $branch_element->getExternalBranchId(),
			"name" => $branch_element->getBranchName(),
			"place" => $branch_element->getPlaceName(),

			"full_address" => $branch_element->getFullAddress(),
			"country" => $branch_element->getCountryCode(),
			"district" => $branch_element->getDistrict(),
			"zip" => $branch_element->getZipCode(),
			"city" => $branch_element->getCity(),
			"street" => $branch_element->getStreet(),

			"url" => $branch_element->getInformationUrl(),
			"opening_hours" => json_encode($branch_element->getOpeningHours()),
			"location_latitude" => $branch_element->getLatitude(),
			"location_longitude" => $branch_element->getLongitude(),
		];
	}

	static function GetXMLBranchName() {
		return "row";
	}

	static function GetRequirements() {
		return null;
	}
}
