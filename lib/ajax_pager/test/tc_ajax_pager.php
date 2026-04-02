<?php
class TcAjaxPager extends TcBase {

	function test_cleaning_page_size(){
		$controller = new Atk14Controller();
		$controller->params = new Dictionary();

		$ap = new AjaxPager($controller);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => 20,
		]);
		$this->assertEquals(20,$ap->options["page_size"]);
		$this->assertEquals([20],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => null
		]);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => "nonsence"
		]);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);


		$ap = new AjaxPager($controller,[
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(11,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => 22,
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(22,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => 999,
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(11,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => "nonsence",
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(11,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		// Getting page_size automatically from $controller->params
		$controller->params["page_size"] = "34";
		$ap = new AjaxPager($controller,[
			"page_size_possibilities" => [14,24,34],
		]);
		$this->assertEquals(34,$ap->options["page_size"]);
		$this->assertEquals([14,24,34],$ap->options["page_size_possibilities"]);

		$controller->params["page_size"] = "999";
		$ap = new AjaxPager($controller,[
			"page_size_possibilities" => [14,24,34],
		]);
		$this->assertEquals(14,$ap->options["page_size"]);
		$this->assertEquals([14,24,34],$ap->options["page_size_possibilities"]);

		$controller->params["page_size"] = "34";
		$ap = new AjaxPager($controller,[
			// page_size_possibilities is not set -> page_size couldn't be taken from $controller->params
		]);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);
	}
}
