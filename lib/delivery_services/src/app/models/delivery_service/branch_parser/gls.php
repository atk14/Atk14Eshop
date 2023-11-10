<?php
/**
 * @see https://doc.gls-czech.cz/index.php/api-shop-delivery-service
 */
namespace DeliveryService\BranchParser;
require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

class Gls extends DeliveryServiceBranchData implements iDeliveryServiceBranchParser {

	/**
	 * compress.zlib 'protocol' allows decompressing gzipped file which is returned by the url.
	 */
	static $BRANCHES_DOWNLOAD_URL = "compress.zlib://https://datarequester.gls-hungary.com/glsconnect/getDropoffPoints.php?ctrcode=CZ";

	# updated parameter seems to be unnecessary
#	static $BRANCHES_DOWNLOAD_URL = "https://datarequester.gls-hungary.com/glsconnect/getDropoffPoints.php?ctrcode=CZ&updated=2015-04-01T12:00:00";

	function getExternalBranchId() {
		$attributes = $this->attributes();
		return (string)$attributes["ID"];
	}

	function getBranchName() {
		$attributes = $this->attributes();
		return (string)$attributes["Name"];
	}

	function getPlaceName() {
		$attributes = $this->attributes();
		return (string)$attributes["Name"];
	}

	function getFullAddress() {
		$attributes = $this->attributes();
		return (string)$attributes["Address"];
	}

	function getCountryCode() {
		$attributes = $this->attributes();
		return (string)$attributes["CtrCode"];
	}

	function getDistrict() {
		return null;
	}

	function getZipCode() {
		$attributes = $this->attributes();
		return (string)$attributes["ZipCode"];
	}

	function getCity() {
		$attributes = $this->attributes();
		return (string)$attributes["CityName"];
	}

	function getStreet() {
		$attributes = $this->attributes();
		return (string)$attributes["Address"];
	}

	function getInformationUrl() {
		return null;
	}

	function getOpeningHours() {
		$_openHoursAr = [];

		$_days = [
			"Monday" => _("Pondělí"),
			"Tuesday" => _("Úterý"),
			"Wednesday" => _("Středa"),
			"Thursday" => _("Čtvrtek"),
			"Friday" => _("Pátek"),
			"Saturday" => _("Sobota"),
			"Sunday" => _("Neděle"),
		];

		foreach($this->Openings->Openings as $_element) {
			$_attrs = $_element->attributes();
			$_day = (string)$_attrs["Day"];
			$_open_day = $_days[$_day];
			$_open_hours = $_attrs["OpenHours"];

			$_hours=[];
			foreach(explode(",", $_open_hours) as $_h) {
				$_h = trim($_h);
				if (preg_match('/^([0-9]{2}:[0-9]{2}).?([0-9]{2}:[0-9]{2})$/u', $_h, $m)) {
					$_hours[] = [
						"open_from" => trim($m[1]),
						"open_to" => trim($m[2]),
					];
				}
			}
			$_ohDay = [
				"day_name" => $_open_day,
				"hours" => $_hours,
			];
			$_openHoursAr[] = $_ohDay;
		}
		return $_openHoursAr;
	}

	function getLatitude() {
		$attributes = $this->attributes();
		return (string)$attributes["GeoLat"];
	}

	function getLongitude() {
		$attributes = $this->attributes();
		return (string)$attributes["GeoLng"];
	}


	static function GetXMLBranchName() {
		return "DropoffPoint";
	}

	static function GetRequirements() {
		return [
#			"API_KEY" => "delivery_services.zasilkovna.api_key",
		];
	}
}
