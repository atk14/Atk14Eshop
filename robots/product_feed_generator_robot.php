<?php
/**
 * Basic examples how to generate product feed for most common price comparators.
 */
class ProductFeedGeneratorRobot extends ApplicationRobot {

	function run() {
		global $ATK14_GLOBAL;

		$reader = null;

		# Create XML product feed for Heureka.cz price comparator
		$generator = new \ProductFeedGenerator\Generator\HeurekaCzGenerator($reader, [
			"logger" => $this->logger,
		]);
		$generator->exportTo($ATK14_GLOBAL->getPublicRoot()."/product_feeds/heureka_cz.xml");

		# Create XML product feed for Google Shopping price comparator
		# As we want the feed to contain prices in EUR, we will use specific PriceFinder
		$generator = new \ProductFeedGenerator\Generator\GoogleShoppingGenerator($reader, [
			"logger" => $this->logger,
			"price_finder" => $this->_getPriceFinder(["currency" => "EUR"]),
		]);
		$generator->exportTo($ATK14_GLOBAL->getPublicRoot()."/product_feeds/google_shopping.xml");

		# Create CSV product feed for Google Merchants
		# The output format is specified inside the GoogleMerchantsGenerator so it is not needed to put it as a parameter
		$generator = new \ProductFeedGenerator\Generator\GoogleMerchantsGenerator($reader, [
			"logger" => $this->logger,
			"output_format" => "csv",
		]);
		$generator->exportTo($ATK14_GLOBAL->getPublicRoot()."/product_feeds/google_merchants.csv");

		# Another example of product feed with some more parameters
		# - lang - slovak product translations will be used to create the feed
		# - hostname - under some conditions might be useful to generate links to products with different hostname
		# - eshop_url - url of the site
		# - feed_title - short description of the eshop. some price comparators use it, some don't.
		$generator = new \ProductFeedGenerator\Generator\GoogleShoppingGenerator($reader, [
			"logger" => $this->logger,
			"lang" => "sk",
			"feed_title" => "ukážkový obchod",
			"hostname" => "ukazkovy-eshop.sk.gibona.com",
			"eshop_url" => "ukazkovy-eshop.gibona.com",
		]);
		$generator->exportTo($ATK14_GLOBAL->getPublicRoot()."/product_feeds/google_shopping_sk.xml");

		return;
	}

	function _getPriceFinder($options=[]) {
		$options += [
			# default currency
			"currency" => null,
		];
		return PriceFinder::GetInstance(null, Currency::FindByCode($options["currency"]));
	}
}
