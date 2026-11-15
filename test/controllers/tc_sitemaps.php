<?php
/**
 *
 * @fixture pages
 */
class TcSitemaps extends TcBase {

	function test(){
		$client = $this->client;
		
		$client->get("sitemaps/index");
		$this->assertEquals("application/xml",$client->getContentType());
		$this->assertStringContains("public, max-age=",$client->getResponseHeader("Cache-Control"));

		$client->get("sitemaps/detail");
		$this->assertEquals("text/html",$client->getContentType());
		$this->assertStringContains("private",$client->getResponseHeader("Cache-Control"));

		// no cache file is ever pre-generated in TEST (see SitemapsController::GetSitemapsDir()),
		// so a valid auth_token is needed here to force a live render instead of getting a 503
		$auth_token = sha1(SECRET_TOKEN."GenerateXmlSitemapForMePlease".date("Y-m-d"));
		$client->get("sitemaps/detail",["format" => "xml", "auth_token" => $auth_token]);
		$this->assertEquals("application/xml",$client->getContentType());
		$this->assertStringContains("public, max-age=",$client->getResponseHeader("Cache-Control"));
	}

	function test_content(){
		$page = $this->pages["testing_page"];
		$page2 = $this->pages["another_testing_page"];

		$this->client->get("sitemaps/detail");
		$this->assertStringContains($page->getTitle(),$this->client->getContent());
		$this->assertStringContains($page2->getTitle(),$this->client->getContent());

		$page->s("indexable",false);
		$page2->s("visible",false);

		$this->client->get("sitemaps/detail");
		$this->assertStringNotContains($page->getTitle(),$this->client->getContent());
		$this->assertStringNotContains($page2->getTitle(),$this->client->getContent());
	}

	function test_invalid_auth_token(){
		$client = $this->client;

		$client->get("sitemaps/detail",["format" => "xml", "auth_token" => "obviously-invalid-token"]);
		$this->assertEquals(403,$client->getStatusCode());

		$client->get("sitemaps/detail_products",["format" => "xml", "auth_token" => "obviously-invalid-token"]);
		$this->assertEquals(403,$client->getStatusCode());
	}

	function test_missing_auth_token_is_not_forbidden(){
		$client = $this->client;

		// an xml request without any auth_token is a legitimate, anonymous request (e.g. from a search engine crawler)
		// it must not be forbidden, it's just not authorized to trigger a fresh render - see _serve_sitemap_from_cache_or_wait()
		$client->get("sitemaps/detail",["format" => "xml"]);
		$this->assertNotEquals(403,$client->getStatusCode());
	}

	function test_invalid_auth_token_is_ignored_outside_xml_format(){
		$client = $this->client;

		// auth_token is only ever checked for format=xml requests
		$client->get("sitemaps/detail",["auth_token" => "obviously-invalid-token"]);
		$this->assertNotEquals(403,$client->getStatusCode());
		$this->assertEquals(200,$client->getStatusCode());
	}

	function test_valid_auth_token_is_accepted(){
		$auth_token = sha1(SECRET_TOKEN."GenerateXmlSitemapForMePlease".date("Y-m-d"));

		$client = $this->client;
		$client->get("sitemaps/detail",["format" => "xml", "auth_token" => $auth_token]);
		$this->assertEquals(200,$client->getStatusCode());
		$this->assertEquals("application/xml",$client->getContentType());
	}
}
