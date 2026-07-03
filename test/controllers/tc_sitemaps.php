<?php
class TcSitemaps extends TcBase {

	function test(){
		$client = $this->client;
		
		$client->get("sitemaps/index");
		$this->assertEquals("application/xml",$client->getContentType());
		$this->assertStringContains("public, max-age=",$client->getResponseHeader("Cache-Control"));

		$client->get("sitemaps/detail");
		$this->assertEquals("text/html",$client->getContentType());
		$this->assertStringContains("private",$client->getResponseHeader("Cache-Control"));

		$client->get("sitemaps/detail",["format" => "xml"]);
		$this->assertEquals("application/xml",$client->getContentType());
		$this->assertStringContains("public, max-age=",$client->getResponseHeader("Cache-Control"));
	}
}
