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

	/**
	 * Returns true if this parser uses a separate feed per country.
	 *
	 * When true, the import filters branches and deactivation by country_code.
	 * When false, the feed is shared across all countries and country_code is ignored.
	 *
	 * Base classes auto-detect this by checking for the {COUNTRY_CODE} placeholder in
	 * $BRANCHES_DOWNLOAD_URL. Parsers that fetch data via an API (e.g. PPL) should
	 * override this method manually.
	 */
	static function HasCountrySpecificFeed();

	public function count();
}

