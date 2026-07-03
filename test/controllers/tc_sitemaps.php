<?php
class TcSitemaps extends TcBase {

	function test(){
		$client = $this->client;
		
		$client->get("sitemaps/index");
		$this->assertStringContains("public, max-age=",$client->getResponseHeader("Cache-Control"));

		$client->get("sitemaps/detail");
		$this->assertStringContains("private",$client->getResponseHeader("Cache-Control"));

		$client->get("sitemaps/detail",["format" => "xml"]);
		$this->assertStringContains("public, max-age=",$client->getResponseHeader("Cache-Control"));
	}
}
