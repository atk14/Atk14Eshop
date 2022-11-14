<?php
class TcMain extends TcBase{
	function test_index(){
		$this->client->get("main/index");
		$this->assertEquals(200,$this->client->getStatusCode());

		$this->assertContains(sprintf('<meta property="og:description" content="%s">', ATK14_APPLICATION_DESCRIPTION), $this->client->getContent());
		$this->assertContains('<meta property="og:title" content="Welcome! | ATK14 Eshop">', $this->client->getContent());
		$this->assertContains('<meta property="og:type" content="website">', $this->client->getContent());
		$this->assertContains(sprintf('<meta property="og:url" content="http://%s/">', ATK14_HTTP_HOST), $this->client->getContent());
	}

	function test_error404(){
		$controller = $this->client->get("main/not_existing_method");
		$this->assertEquals(404,$this->client->getStatusCode());

		$this->client->get("main/error404");
		$this->assertEquals(404,$this->client->getStatusCode());
	}
}
