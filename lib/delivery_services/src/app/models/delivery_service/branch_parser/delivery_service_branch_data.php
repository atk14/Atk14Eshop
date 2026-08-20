<?php

namespace DeliveryService\BranchParser;

class DeliveryServiceBranchData extends \SimpleXmlElement {

	var $nsPrefix = "";

	/**
	 * @note can not be used in PHP version < 8
	 */
	/*
	public function __construct(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		parent::__construct($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
		$this->tuneNamespaces();
	}
	 */

	public static function GetInstance(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$instance = new static($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
		$instance->tuneNamespaces();
		return $instance;
	}

	function tuneNamespaces() {
		// Prohledani namespacu a prirazeni prefixu tam, kde je prazdny.
		// jinak nelze pouzit volani xpath()

		foreach($this->getDocNamespaces() as $strPrefix => $strNamespace) {
			if (in_array($strPrefix, ["xsi", "xsd"])) {
				continue;
			}
			if(strlen($strPrefix)==0) {
				$this->nsPrefix="default"; //Assign an arbitrary namespace prefix.
			}
			$this->registerXPathNamespace($this->nsPrefix,$strNamespace);
		}

		$this->registerXPathNamespace("br", "http://atk14.org/branch");
	}

	public function _getBranchNodes($options=[]) {
		$nsPrefix = isset($this->nsPrefix) ? $this->nsPrefix : "";
		$_branch_element_name = sprintf("//%s%s", ($nsPrefix ? $nsPrefix.":" : ""), static::GetXMLBranchName());

		return $this->xpath($_branch_element_name);;
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
			"active" => $this->isActive(),
		];
	}

	static function FetchFeed($feed_url) {
		$uf = new \UrlFetcher($feed_url,["http_version" => "1.1"]);
		if(!$uf->found()){
			throw new \Exception("UrlFetcher: ".$uf->getErrorMessage()." (url: ".$uf->getUrl().")");
		}
		$out = (string)$uf->getContent();
		if(
			$uf->getHeader("Content-Encoding") === "gzip" ||
			$uf->getContentType() === "gzip" // weird, but see https://datarequester.gls-hungary.com/glsconnect/getDropoffPoints.php?ctrcode=CZ
		){
			$out = gzdecode($out);
			if($out===false){
				throw new \Exception("gzdecode failed (url: ".$uf->getUrl().")");
			}
		}
		return $out;
	}

	static function HasCountrySpecificFeed() {
		$urls = (array)static::$BRANCHES_DOWNLOAD_URL;
		foreach ($urls as $url) {
			if (str_contains((string)$url, '{COUNTRY_CODE}')) {
				return true;
			}
		}
		return false;
	}

	static function GetBranchesDownloadUrl($country_code = 'cz') {
		$url = static::$BRANCHES_DOWNLOAD_URL;
		if (is_array($url)) {
			return array_map(function($u) use ($country_code) { return str_replace('{COUNTRY_CODE}', strtoupper($country_code), $u); }, $url);
		}
		return str_replace('{COUNTRY_CODE}', strtoupper($country_code), (string)$url);
	}
}
