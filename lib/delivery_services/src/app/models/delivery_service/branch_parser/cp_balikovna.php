<?php
namespace DeliveryService\BranchParser;
require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

class CpBalikovna extends DeliveryServiceBranchData implements iDeliveryServiceBranchParser {

	static $BRANCHES_DOWNLOAD_URL = "http://napostu.ceskaposta.cz/vystupy/balikovny.xml";

	function getExternalBranchId() {
		return trim((string)$this->PSC);
	}

	function getBranchName() {
		return trim((string)$this->NAZEV);
	}

	function getPlaceName() {
		return trim((string)$this->NAZEV);
	}

	function getFullAddress() {
		return trim((string)$this->ADRESA);
	}

	function getCountryCode() {
		return "CZ";
	}

	function getDistrict() {
		return trim((string)$this->OBEC);
	}

	function getZipCode() {
		return  trim((string)$this->PSC);
	}

	private function _parseAddress() {
		$address = explode(",", (string)$this->ADRESA);

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
		foreach($this->OTEV_DOBY->den as $den) {
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

	function toArray() {
		return [
			"external_branch_id" => $this->getExternalBranchId(),
			"name" => $this->getBranchName(),
			"place" => $this->getPlaceName(),

			"full_address" => $this->getFullAddress(),
			"country" => $this->getCountryCode(),
			"district" => $this->getDistrict(),
			"zip" => $this->getZipCode(),
			"city" => $this->getCity(),
			"street" => $this->getStreet(),

			"url" => $this->getInformationUrl(),
			"opening_hours" => json_encode($this->getOpeningHours()),
			"location_latitude" => $this->getLatitude(),
			"location_longitude" => $this->getLongitude(),
		];
	}

	static function GetXMLBranchName() {
		return "row";
	}

	static function GetRequirements() {
		return null;
	}
}
