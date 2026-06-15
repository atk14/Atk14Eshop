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
	public function isActive();

	static function GetRequirements();

	/**
	 * Returns the feed URL for the given country code.
	 *
	 * Parsers that serve multiple countries should override this method
	 * and return country-specific URLs.
	 *
	 * @param string $country_code e.g. 'cz', 'sk'
	 * @return string|array
	 */
	static function GetBranchesDownloadUrl($country_code = 'cz');

	public function count();
}

