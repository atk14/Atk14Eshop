<?php
namespace DeliveryService\BranchParser;

interface iDeliveryServiceBranchParser {
	/**
	 * Nazev xml elementu, ktery obsahuje informace o pobocce.
	 */
	public static function GetXMLBranchName();
	/**
	 * Ziskani hodnot z xml elementu, ktery obsahuje informace o pobocce.
	 */
	public function toArray();

	public function getExternalBranchId();
	public function getBranchName();
	public function getPlaceName();

	public function getFullAddress();
	public function getCountryCode();
	public function getZipCode();
	public function getCity();
	public function getStreet();

	public function getInformationUrl();

	public function getOpeningHours();
	public function getLatitude();
	public function getLongitude();

	static function GetRequirements();
}

