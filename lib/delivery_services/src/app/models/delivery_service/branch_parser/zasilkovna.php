<?php
namespace DeliveryService\BranchParser;
require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

class Zasilkovna extends DeliveryServiceBranchData implements iDeliveryServiceBranchParser {

	static $BRANCHES_DOWNLOAD_URL = "https://www.zasilkovna.cz/api/v4/{API_KEY}/branch.xml";

	function getExternalBranchId() {
		return (string)$this->branch_element->id;
	}

	function getBranchName() {
		return (string)$this->branch_element->name;
	}

	function getPlaceName() {
		return (string)$this->branch_element->place;
	}

	function getFullAddress() {
		return (string)$this->branch_element->name;
	}

	function getCountryCode() {
		return \Translate::Upper((string)$this->branch_element->country);
	}

	function getDistrict() {
		return trim((string)$this->branch_element->district);
	}

	function getZipCode() {
		return preg_replace("/\s/", "", trim((string)$this->branch_element->zip));
	}

	function getCity() {
		return (string)$this->branch_element->city;
	}

	function getStreet() {
		return (string)$this->branch_element->street;
	}

	function getInformationUrl() {
		return (string)$this->branch_element->url;
	}

	function getOpeningHours() {
		$_openHoursAr = [];

		$_days = [
			"monday" => _("Pondělí"),
			"tuesday" => _("Úterý"),
			"wednesday" => _("Středa"),
			"thursday" => _("Čtvrtek"),
			"friday" => _("Pátek"),
			"saturday" => _("Sobota"),
			"sunday" => _("Neděle"),
		];

		foreach($_days as $element_name => $day_name) {
			$_value = (string)$this->branch_element->openingHours->regular->$element_name;
			$_values = explode(",", $_value);
			$_hours = [];
			foreach($_values as $_v) {
				$_v = trim($_v);
				if (preg_match('/^([0-9]{2}:[0-9]{2}).?([0-9]{2}:[0-9]{2})$/u', $_v, $m)) {
					$_hours[] = [
						"open_from" => trim($m[1]),
						"open_to" => trim($m[2]),
					];
				}
			}
			$_ohDay = [
				"day_name" => $day_name,
				"hours" => $_hours,
			];
			$_openHoursAr[] = $_ohDay;
		}
		return $_openHoursAr;
	}

	function getLatitude() {
		return (float)$this->branch_element->latitude;
	}

	function getLongitude() {
		return (float)$this->branch_element->longitude;
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
		return "branch";
	}
}
