<?php
namespace DeliveryService\BranchParser;

require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

/**
 * @link https://api.ulozenka.cz/v3 Documentation of API of WE|DO services.
 *
 */
class WedoUlozenka extends DeliveryServiceJsonBranchData implements iDeliveryServiceBranchParser {

	static $BRANCHES_DOWNLOAD_URL = "https://api.ulozenka.cz/v3/transportservices/1/branches";

	function getExternalBranchId() {
		return (string)$this["id"];
	}

	function getBranchName() {
		return $this["name"];
	}

	function getPlaceName() {
		$place = trim($this["name"]);
		if(preg_match('/\(([^\(\)]+)\)$/',$place,$matches)){ // "Praha, K Šeberáku 180/1 (MarexTrade s.r.o.)" -> "MarexTrade s.r.o."
			$place = trim($matches[1]);
		}
		return $place;
	}

	function getFullAddress() {
		return $this->getStreet().", ".$this->getCity();
	}

	function getCountryCode() {
		$_map = [
			"CZE" => "CZ",
		];
		$out = $this["country"];
		if (isset($_map[$out])) {
			$out = $_map[$out];
		}

		return $out;
	}

	function getDistrict() {
		return $this["district"]["name"];
	}

	function getZipCode() {
		return $this["zip"];
	}

	function getCity() {
		return $this["town"];
	}

	function getStreet() {
		return trim($this["street"]." ".$this["house_number"]);
	}

	function getInformationUrl() {
		return $this["_links"]["website"]["href"];
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
			$_values = $this["opening_hours"]["regular"]["$element_name"]["hours"];
			$_hours = [];
			foreach($_values as $_v) {
				$_hours[] = [
					"open_from" => $_v["open"],
					"open_to" => $_v["close"],
				];
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
		return (float)$this["gps"]["latitude"];
	}

	function getLongitude() {
		return (float)$this["gps"]["longitude"];
	}

	function isActive() {
		return true;
	}

	static function GetXMLBranchName() {
#		return "branch";
	}

	static function GetRequirements() {
		return [
#			"API_KEY" => "delivery_services.zasilkovna.api_key",
		];
	}
}
