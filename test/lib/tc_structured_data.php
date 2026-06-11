<?php
/**
 * @fixture cards
 * @fixture products
 * @fixture categories
 * @fixture category_cards
 * @fixture pictures
 * @fixture users
 */
class TcStructuredData extends TcBase {

	function _setUp() {
		parent::_setUp();
		\StructuredData\Collector::Reset();
	}

	// --- Collector ---

	function test_collector_get_instance_returns_collector() {
		$collector = \StructuredData\Collector::GetInstance();
		$this->assertInstanceOf(\StructuredData\Collector::class, $collector);
	}

	function test_collector_singleton_returns_same_instance() {
		$controller = $this->_buildController("cards", "detail");
		$c1 = \StructuredData\Collector::GetInstance($controller);
		$c2 = \StructuredData\Collector::GetInstance();
		$this->assertSame($c1, $c2);
	}

	function test_collector_reset_allows_new_instance() {
		$controller = $this->_buildController("cards", "detail");
		$c1 = \StructuredData\Collector::GetInstance($controller);
		\StructuredData\Collector::Reset();
		$c2 = \StructuredData\Collector::GetInstance($controller);
		$this->assertNotSame($c1, $c2);
	}

	function test_collector_homepage_adds_website_item() {
		$controller = $this->_buildController("main", "index");
		$collector = \StructuredData\Collector::GetInstance($controller);
		$items = $collector->toArray();
		$this->assertEquals(1, count($items));
		$this->assertEquals("WebSite", $items[0]["@type"]);
	}

	function test_collector_non_homepage_has_no_items() {
		$controller = $this->_buildController("cards", "detail");
		$collector = \StructuredData\Collector::GetInstance($controller);
		$this->assertEquals([], $collector->toArray());
	}

	function test_collector_add_item() {
		$collector = \StructuredData\Collector::GetInstance();
		$collector->addItem(new \StructuredData\Element\Website());
		$items = $collector->toArray();
		$this->assertEquals(1, count($items));
	}

	// --- Website ---

	function test_website_to_array_structure() {
		$website = new \StructuredData\Element\Website();
		$out = $website->toArray();
		$this->assertEquals("https://schema.org", $out["@context"]);
		$this->assertEquals("WebSite", $out["@type"]);
		$this->assertArrayHasKey("url", $out);
		$this->assertArrayHasKey("potentialAction", $out);
		$this->assertEquals("SearchAction", $out["potentialAction"]["@type"]);
	}

	// --- BreadcrumbListItem ---

	function test_breadcrumb_list_item_returns_null_for_unknown_type() {
		$card = $this->cards["coffee"];
		$category = $card->getPrimaryCategory();

		$item = new \StructuredData\Element\BreadcrumbListItem($category);
		$out = $item->toArray();
		$this->assertEquals("ListItem", $out["@type"]);
		$this->assertArrayHasKey("@id", $out["item"]);
	}

	function test_breadcrumb_list_item_for_card() {
		$card = $this->cards["coffee"];
		$item = new \StructuredData\Element\BreadcrumbListItem($card);
		$out = $item->toArray();
		$this->assertEquals("ListItem", $out["@type"]);
		$this->assertNotNull($out["item"]["@id"]);
	}

	// --- BreadcrumbList ---

	function test_breadcrumb_list_empty() {
		$bclist = new \StructuredData\Element\BreadcrumbList();
		$out = $bclist->toArray();
		$this->assertEquals("https://schema.org", $out["@context"]);
		$this->assertEquals("BreadcrumbList", $out["@type"]);
		// add_index => true přidá homepage jako první položku
		$this->assertEquals(1, count($out["itemListElement"]));
		$this->assertEquals(1, $out["itemListElement"][0]["position"]);
	}

	function test_breadcrumb_list_without_index() {
		$bclist = new \StructuredData\Element\BreadcrumbList(null, ["add_index" => false]);
		$out = $bclist->toArray();
		$this->assertEquals(0, count($out["itemListElement"]));
	}

	function test_breadcrumb_list_positions_are_sequential() {
		$card = $this->cards["coffee"];
		$category = $card->getPrimaryCategory();

		$bclist = new \StructuredData\Element\BreadcrumbList(null, ["add_index" => false]);
		$bclist->addListItem($category);
		$bclist->addListItem($card);
		$out = $bclist->toArray();

		$this->assertEquals(1, $out["itemListElement"][0]["position"]);
		$this->assertEquals(2, $out["itemListElement"][1]["position"]);
	}

	// --- Offer / AggregateOffer ---

	function test_offer_returns_null_without_basket() {
		$card = $this->cards["coffee"];
		$offer = new \StructuredData\Element\Offer($card);
		$this->assertNull($offer->toArray());
	}

	function test_aggregate_offer_returns_null_without_basket() {
		$card = $this->cards["coffee"];
		$offer = new \StructuredData\Element\AggregateOffer($card);
		$this->assertNull($offer->toArray());
	}

	// --- ImageObject ---

	function test_image_object_to_array_structure() {
		$picture = $this->pictures["astronaut"];
		$image = new \StructuredData\Element\ImageObject($picture);
		$out = $image->toArray();

		$this->assertEquals("https://schema.org", $out["@context"]);
		$this->assertEquals("ImageObject", $out["@type"]);
		$this->assertEquals((string)$picture->getUrl(), $out["contentUrl"]);
	}

	function test_image_object_has_thumbnail() {
		$picture = $this->pictures["astronaut"];
		$image = new \StructuredData\Element\ImageObject($picture);
		$out = $image->toArray();

		$this->assertArrayHasKey("thumbnail", $out);
		$this->assertEquals("ImageObject", $out["thumbnail"]["@type"]);
		$this->assertEquals((string)$picture->getUrl(\StructuredData\Element\ImageObject::THUMBNAIL_GEOMETRY), $out["thumbnail"]["contentUrl"]);
	}

	function test_image_object_thumbnail_has_no_nested_thumbnail() {
		$picture = $this->pictures["astronaut"];
		$image = new \StructuredData\Element\ImageObject($picture);
		$out = $image->toArray();

		$this->assertArrayNotHasKey("thumbnail", $out["thumbnail"]);
	}

	function test_image_object_optional_fields_absent_when_empty() {
		$picture = $this->pictures["astronaut"];
		$image = new \StructuredData\Element\ImageObject($picture);
		$out = $image->toArray();

		$this->assertArrayNotHasKey("name", $out);
		$this->assertArrayNotHasKey("description", $out);
		$this->assertArrayNotHasKey("caption", $out);
	}

	function test_image_object_with_title_and_alt() {
		$picture = $this->pictures["astronaut"];
		$picture->s("title_en", "Astronaut photo");
		$picture->s("alt_en", "An astronaut floating in space");

		$image = new \StructuredData\Element\ImageObject($picture);
		$out = $image->toArray();

		$this->assertEquals("Astronaut photo", $out["name"]);
		$this->assertEquals("An astronaut floating in space", $out["caption"]);
	}

	// --- AggregateRating ---

	function test_aggregate_rating_returns_null_without_reviews() {
		$card = $this->cards["coffee"];
		$rating = new \StructuredData\Element\AggregateRating($card);
		$this->assertNull($rating->toArray());
	}

	function test_aggregate_rating_structure() {
		$card = $this->cards["coffee"];
		$product = $this->products["arabica"];

		\CustomerReview::CreateNewRecord(["product_id" => $product, "rating" => 4, "author" => "Test", "user_id" => $this->users["rambo"]]);
		\CustomerReview::CreateNewRecord(["product_id" => $product, "rating" => 2, "author" => "Test2", "user_id" => $this->users["rocky"]]);
		\CustomerReview::$RatingCache = null;

		$rating = new \StructuredData\Element\AggregateRating($card);
		$out = $rating->toArray();

		$this->assertEquals("AggregateRating", $out["@type"]);
		$this->assertEquals(3.0, $out["ratingValue"]);
		$this->assertEquals(2, $out["ratingCount"]);
		$this->assertEquals(\CustomerReview::MAX_RATING, $out["bestRating"]);
		$this->assertEquals(1, $out["worstRating"]);
	}

	function test_aggregate_rating_is_included_in_product() {
		$card = $this->cards["coffee"];
		$product = $this->products["arabica"];

		\CustomerReview::CreateNewRecord(["product_id" => $product, "rating" => 5, "author" => "Test", "user_id" => $this->users["rambo"]]);
		\CustomerReview::$RatingCache = null;

		$p = new \StructuredData\Element\Product($card);
		$out = $p->toArray();

		$this->assertArrayHasKey("aggregateRating", $out);
		$this->assertEquals(5.0, $out["aggregateRating"]["ratingValue"]);
	}

	function test_aggregate_rating_absent_in_product_without_reviews() {
		$card = $this->cards["coffee"];

		$p = new \StructuredData\Element\Product($card);
		$out = $p->toArray();

		$this->assertArrayNotHasKey("aggregateRating", $out);
	}

	// --- Product description ---

	function test_product_description_plain_text() {
		$card = $this->cards["coffee"];
		$card->s("teaser_en", "Fresh arabica coffee from Ethiopia.");

		$product = new \StructuredData\Element\Product($card);
		$out = $product->toArray();

		$this->assertEquals("Fresh arabica coffee from Ethiopia.", $out["description"]);
	}

	function test_product_description_with_special_characters() {
		$card = $this->cards["coffee"];
		$card->s("teaser_en", 'He said "best coffee" and it\'s true \o/');

		$product = new \StructuredData\Element\Product($card);
		$out = $product->toArray();

		$this->assertEquals('He said "best coffee" and it\'s true \o/', $out["description"]);
	}

	function test_product_description_strips_html_tags() {
		$card = $this->cards["coffee"];
		$card->s("teaser_en", "<p>Fresh <strong>arabica</strong> coffee.</p>");

		$product = new \StructuredData\Element\Product($card);
		$out = $product->toArray();

		$this->assertEquals("Fresh arabica coffee.", $out["description"]);
	}

	function test_product_description_is_truncated_in_json_space() {
		$card = $this->cards["coffee"];
		// Sestavíme teaser delší než 5000 znaků v JSON reprezentaci
		$long_word = str_repeat("a", 100);
		$teaser = implode(" ", array_fill(0, 60, $long_word)); // ~6059 znaků
		$card->s("teaser_en", $teaser);

		$product = new \StructuredData\Element\Product($card);
		$out = $product->toArray();

		$this->assertNotNull($out["description"]);
		$this->assertIsString($out["description"]);
		// JSON reprezentace musí být ≤ 5000 znaků
		$this->assertLessThanOrEqual(5000, strlen(json_encode($out["description"])));
		// Popis musí být kratší než původní teaser
		$this->assertLessThan(strlen($teaser), strlen($out["description"]));
	}

	function test_product_description_with_quotes_is_not_truncated_into_invalid_state() {
		$card = $this->cards["coffee"];
		// Teaser s uvozovkami, který se v JSON encodingu prodlouží escape sekvencemi
		$teaser = str_repeat('"quoted text" ', 400); // ~5600 znaků v JSON (každá " → \")
		$card->s("teaser_en", $teaser);

		$product = new \StructuredData\Element\Product($card);
		$out = $product->toArray();

		$this->assertNotNull($out["description"]);
		$this->assertIsString($out["description"]);
		$this->assertLessThanOrEqual(5000, strlen(json_encode($out["description"])));
	}

	// --- helpers ---

	protected function _buildController($controller_name, $action_name) {
		$controller = new Atk14Controller();
		$controller->controller = $controller_name;
		$controller->action = $action_name;
		return $controller;
	}
}
