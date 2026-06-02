<?php
/**
 * @fixture cards
 * @fixture products
 * @fixture categories
 * @fixture category_cards
 * @fixture articles
 * @fixture videos
 */
class TcStructuredData extends TcBase {

	function _setUp() {
		parent::_setUp();
		// Singleton přežívá mezi requesty ve stejném procesu – resetujeme před každým testem
		\StructuredData\Collector::Reset();
	}

	function test_homepage_has_website_json_ld() {
		$this->client->get("main/index");
		$this->assertEquals(200, $this->client->getStatusCode());
		$this->_assertJsonLdType("WebSite");
	}

	function test_card_detail_has_breadcrumb_json_ld() {
		$card = $this->cards["coffee"];
		$this->client->get("cards/detail", ["id" => $card]);
		$this->assertEquals(200, $this->client->getStatusCode());
		$this->_assertJsonLdType("BreadcrumbList");
	}

	function test_card_detail_has_product_json_ld() {
		$card = $this->cards["coffee"];
		$this->client->get("cards/detail", ["id" => $card]);
		$this->assertEquals(200, $this->client->getStatusCode());
		$this->_assertJsonLdType("Product");
	}

	function test_card_detail_with_video_has_video_object_json_ld() {
		$card = $this->cards["coffee"];

		$video = Video::CreateNewRecord([
			"url" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
			"html" => '<iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"></iframe>',
			"image_url" => null,
			"title_en" => "Coffee making process",
		]);

		$section_type = CardSectionType::FindByCode("info");
		$section = CardSection::CreateNewRecord([
			"card_id" => $card,
			"card_section_type_id" => $section_type,
			"body_en" => "[#{$video->getId()} Video: Coffee making process]",
		]);

		\StructuredData\Collector::Reset();
		$this->client->get("cards/detail", ["id" => $card]);
		$this->assertEquals(200, $this->client->getStatusCode());
		$this->_assertJsonLdType("VideoObject");

		$blocks = $this->_getJsonLdBlocks();
		$video_block = current(array_filter($blocks, function($b) { return ($b["@type"] ?? null) === "VideoObject"; }));
		$this->assertEquals("Coffee making process", $video_block["name"]);
		$this->assertEquals("https://www.youtube.com/watch?v=dQw4w9WgXcQ", $video_block["embedUrl"]);
	}

	function test_article_with_video_has_video_object_json_ld() {
		$video = $this->videos["coffee_video"];

		$article = Article::CreateNewRecord([
			"title_en" => "Article with video",
			"slug_en" => "article-with-video",
			"published_at" => date("Y-m-d"),
			"body_en" => "[#{$video->getId()} Video: Coffee making process]",
		]);

		\StructuredData\Collector::Reset();
		$this->client->get("articles/detail", ["id" => $article]);
		$this->assertEquals(200, $this->client->getStatusCode());
		$this->_assertJsonLdType("VideoObject");

		$blocks = $this->_getJsonLdBlocks();
		$video_block = current(array_filter($blocks, function($b) { return ($b["@type"] ?? null) === "VideoObject"; }));
		$this->assertEquals("Coffee making process", $video_block["name"]);
		$this->assertEquals($video->g("url"), $video_block["embedUrl"]);
	}

	function test_invisible_card_has_no_product_json_ld() {
		$card = $this->cards["coffee"];
		$card->s("visible", false);
		Cache::Clear();
		\StructuredData\Collector::Reset();

		$this->client->get("cards/detail", ["id" => $card]);
		$this->assertEquals(404, $this->client->getStatusCode());
		$this->_assertNoJsonLdType("Product");
	}

	// --- helpers ---

	protected function _assertJsonLdType($type) {
		$blocks = $this->_getJsonLdBlocks();
		$types = array_column($blocks, "@type");
		$this->assertContains($type, $types, "JSON-LD block of type \"$type\" not found in response");
	}

	protected function _assertNoJsonLdType($type) {
		$blocks = $this->_getJsonLdBlocks();
		$types = array_column($blocks, "@type");
		$this->assertNotContains($type, $types, "JSON-LD block of type \"$type\" should not be present in response");
	}

	protected function _getJsonLdBlocks() {
		$content = $this->client->getContent();
		preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);
		$blocks = [];
		foreach ($matches[1] as $json) {
			$decoded = json_decode(trim($json), true);
			if ($decoded) {
				$blocks[] = $decoded;
			}
		}
		return $blocks;
	}
}
