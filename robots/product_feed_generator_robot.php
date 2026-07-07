<?php
/**
 * Basic examples how to generate product feed for most common price comparators.
 */
class ProductFeedGeneratorRobot extends ApplicationRobot {

	protected $options = [];

	function run() {
		global $ATK14_GLOBAL;
		global $argv;

		$reader = null;
		array_shift($argv);
		array_shift($argv);

		$this->options = [
			"full_feed" => null,
			"logger" => $this->logger,
		];

		$todo_feeds = [];

		$feeds_config = [
			# Create XML product feed for Heureka.cz price comparator
			"heureka_cz" => [
				"class" => \ProductFeedGenerator\Generator\HeurekaCzGenerator::class,
				"output" => "/product_feeds/heureka_cz.xml",
			],
			# Create XML product feed for Google Shopping price comparator
			# As we want the feed to contain prices in EUR, we will use specific PriceFinder
			"google_shopping" => [
				"class" => \ProductFeedGenerator\Generator\GoogleShoppingGenerator::class,
				"output" => "/product_feeds/google_shopping.xml",
				"options" => [
					"price_finder" => $this->_getPriceFinder(["currency" => "EUR"]),
				],
			],
			# Create CSV product feed for Google Merchants
			# The output format is specified inside the GoogleMerchantsGenerator so it is not needed to put it as a parameter
			"google_merchants" => [
				"class" => \ProductFeedGenerator\Generator\GoogleMerchantsGenerator::class,
				"output" => "/product_feeds/google_merchants.csv",
				"options" => [
					"output_format" => "csv",
				],
			],
			# Google Shopping feed with some more parameters
			# - lang - slovak product translations will be used to create the feed
			# - hostname - under some conditions might be useful to generate links to products with different hostname
			# - eshop_url - url of the site
			# - feed_title - short description of the eshop. some price comparators use it, some don't.
			"google_shopping_sk" => [
				"class" => \ProductFeedGenerator\Generator\GoogleShoppingGenerator::class,
				"output" => "/product_feeds/google_shopping_sk.xml",
				"options" => [
					"lang" => "sk",
					"feed_title" => "ukážkový obchod",
					"hostname" => "ukazkovy-eshop.sk.gibona.com",
					"eshop_url" => "ukazkovy-eshop.gibona.com",
				],
			],
		];

		$known_feeds = array_keys($feeds_config);

		while($prm = array_shift($argv)) {
			switch($prm) {
			case "-ff":
				$this->options["full_feed"] = true;
				break;
			default:
				$todo_feeds[] = $prm;
				break;
			}
		}

		if ($todo_feeds && !array_intersect($known_feeds, $todo_feeds)) {
			$this->logger->info(sprintf("no known feeds given: %s", join(", ", $todo_feeds)));
			return;
		}

		if ($todo_feeds && ($unknown_feeds = array_diff($todo_feeds, $known_feeds))) {
			$this->logger->info(sprintf("some feeds will not be generated, unknown types: %s", join(", ", $unknown_feeds)));
		}

		$this->logger->flush();

		if(!file_exists($ATK14_GLOBAL->getPublicRoot()."/product_feeds")){
			Files::MkDir($ATK14_GLOBAL->getPublicRoot()."/product_feeds");
		}

		if (!$todo_feeds) {
			$todo_feeds = $known_feeds;
		}

		foreach ($todo_feeds as $feed_name) {
			if (!isset($feeds_config[$feed_name])) { continue; }
			$config = $feeds_config[$feed_name];
			$class = $config["class"];
			$options = array_merge($this->options, $config["options"] ?? []);
			$generator = new $class($reader, $options);
			$generator->exportTo($ATK14_GLOBAL->getPublicRoot().$config["output"]);
		}
	}

	function _getPriceFinder($options=[]) {
		$options += [
			# default currency
			"currency" => null,
		];
		return PriceFinder::GetInstance(null, Currency::FindByCode($options["currency"]));
	}
}
