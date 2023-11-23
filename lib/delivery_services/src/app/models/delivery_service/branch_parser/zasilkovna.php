<?php
namespace DeliveryService\BranchParser;
require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

/**
 * @link https://docs.packetery.com/01-pickup-point-selection/04-branch-export-v4.html Documentation of API
 *
 */
class Zasilkovna extends DeliveryServiceBranchData implements iDeliveryServiceBranchParser {

	static $BRANCHES_DOWNLOAD_URL = "https://www.zasilkovna.cz/api/v4/{API_KEY}/branch.xml";

	function getExternalBranchId() {
		return (string)$this->id;
	}

	function getBranchName() {
		return (string)$this->name;
	}

	function getPlaceName() {
		return (string)$this->place;
	}

	function getFullAddress() {
		return (string)$this->name;
	}

	function getCountryCode() {
		return \Translate::Upper((string)$this->country);
	}

	function getDistrict() {
		return trim((string)$this->district);
	}

	function getZipCode() {
		return preg_replace("/\s/", "", trim((string)$this->zip));
	}

	function getCity() {
		return (string)$this->city;
	}

	function getStreet() {
		return (string)$this->street;
	}

	function getInformationUrl() {
		return (string)$this->url;
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
			$_value = (string)$this->openingHours->regular->$element_name;
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
		return (float)$this->latitude;
	}

	function getLongitude() {
		return (float)$this->longitude;
	}

	function isActive() {
		if ((int)$this->status->statusId===5) {
			return false;
		}
		return true;
	}

	static function GetXMLBranchName() {
		return "branch";
	}

	static function GetRequirements() {
		return [
			"API_KEY" => "delivery_services.zasilkovna.api_key",
		];
	}
}
