<?php
class DigitalContentsRouter extends Atk14Router {

	function setUp(){
		// Odkaz pro zobrazeni digitalniho souboru z objednavky, ...
		$this->addRoute("/digitalni-obsah/<order_token>/<token>/<filename>","cs/digital_contents/download");
		$this->addRoute("/digitalny-obsah/<order_token>/<token>/<filename>","sk/digital_contents/download");
		$this->addRoute("/digital-content/<order_token>/<token>/<filename>","en/digital_contents/download");
		// ... odkaz pro zobrazeni prehledu digitalniho obsahu
		$this->addRoute("/digitalni-obsah/<order_token>/","cs/digital_contents/index");
		$this->addRoute("/digitalny-obsah/<order_token>/","sk/digital_contents/index");
		$this->addRoute("/digital-content/<order_token>/","en/digital_contents/index");
	}
}
