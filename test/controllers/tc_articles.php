<?php
/**
 *
 * @fixture articles
 */
class TcArticles extends TcBase {

	function test(){
		$this->client->get("articles/detail",array("id" => $this->articles["testing_article"]->getId()));
		$this->assertContains(">Testing Article</h1>",$this->client->getContent());
		$this->assertContains("<title>Testing Article",$this->client->getContent());
		$this->assertContains('<meta name="description" content="Testing teaser">',$this->client->getContent());

		$this->client->get("articles/detail",array("id" => $this->articles["interesting_article"]->getId()));
		$this->assertContains(">Interesting Article</h1>",$this->client->getContent());
		$this->assertContains("<title>Page title",$this->client->getContent());
		$this->assertContains('<meta name="description" content="Page description">',$this->client->getContent());

		$this->_assertOGProperties();
	}

	protected function _assertOGProperties() {
		$this->assertContains('<meta property="og:description" content="Interesting teaser">', $this->client->getContent());
		$this->assertContains('<meta property="og:title" content="Interesting Article">', $this->client->getContent());
		$this->assertContains('<meta property="og:type" content="article">', $this->client->getContent());
		$this->assertContains('<meta property="og:url" content="http://atk14eshop.localhost/articles/interesting-article/">', $this->client->getContent());
	}
}
