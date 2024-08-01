<?php
/**
 * @see https://doc.gls-czech.cz/index.php/api-shop-delivery-service
 */
namespace DeliveryService\BranchParser;
require_once(__DIR__."/i_delivery_service_branch_parser.php");

use DeliveryService\BranchParser;

class Ppl extends DeliveryServiceBranchStdClassData implements iDeliveryServiceBranchParser {

	/**
	 */
	static $BRANCHES_DOWNLOAD_URL = null;


	function getExternalBranchId() {
		return $this->_data->ParcelShopCode;
	}

	function getBranchName() {
		return $this->_data->Name2; // e.g. "PPL Parcelshop 106", "AlzaBox 104"
	}

	function getPlaceName() {
		return $this->_data->Name; // e.g. "Top drogerie Michal Zrubec"
	}

	function getFullAddress() {
		$fa = [
			$this->_data->Street,
			$this->_data->ZipCode,
			$this->_data->City,
		];
		return join(", ", array_filter($fa));;
	}

	function getCountryCode() {
		return $this->_data->Country;
	}

	function getDistrict() {
		return null;
	}

	function getZipCode() {
		return $this->_data->ZipCode;
	}

	function getCity() {
		return $this->_data->City;
	}

	function getStreet() {
		return $this->_data->Street;
	}

	function getInformationUrl() {
		return null;
	}

	function getOpeningHours() {
		$_openHoursAr = [];

		$_days = [
			2 => _("Pondělí"),
			3 => _("Úterý"),
			4 => _("Středa"),
			5 => _("Čtvrtek"),
			6 => _("Pátek"),
			7 => _("Sobota"),
			1 => _("Neděle"),
		];

		$_workhour = $this->_data->WorkHours->MyApiKTMWorkHour;
		if (!is_array($_workhour)) {
			$_workhour = [$_workhour];
		}
		foreach($_workhour as $_element) {
			$_day = $_element->Day;
			$_open_day = $_days[$_day];
			$_open_hours_from = $_element->From;
			$_open_hours_to = $_element->To;

			$_hours=[];
			$_hours[] = [
				"open_from" => $_open_hours_from,
				"open_to" => $_open_hours_to,
			];

			$_ohDay = [
				"day_name" => $_open_day,
				"hours" => $_hours,
			];
			$_openHoursAr[] = $_ohDay;
		}
		return $_openHoursAr;
	}

	function getLatitude() {
		$_degree = $this->_data->GPSLocation->GPS_N_D;
		$_min = $this->_data->GPSLocation->GPS_N_M;
		$_sec = $this->_data->GPSLocation->GPS_N_S;
		$_lat = $_degree + (( ($_min * 60) + $_sec) / 3600 );
		return $_lat;
	}

	function getLongitude() {
		$_degree = $this->_data->GPSLocation->GPS_E_D;
		$_min = $this->_data->GPSLocation->GPS_E_M;
		$_sec = $this->_data->GPSLocation->GPS_E_S;
		$_long = $_degree + (( ($_min * 60) + $_sec) / 3600 );
		return $_long;
	}

	function isActive() {
		return true;
	}

	static function GetXMLBranchName() {
		return null;
	}

	static function GetRequirements() {
		return null;
	}

	static function FetchFeed($feed_url) {
		$pplMyApi = new \Salamek\PplMyApi\Api;
		$result = $pplMyApi->getParcelShops($code = null, $countryCode = \Salamek\PplMyApi\Enum\Country::CZ);
		return $result;
	}
}
