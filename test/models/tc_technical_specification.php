<?php
/**
 *
 * @fixture cards
 * @fixture technical_specification_keys
 * @fixture technical_specifications
 */
class TcTechnicalSpecification extends TcBase {

	function test(){
		$ts = $this->technical_specifications["coffee__aroma"];

		$lang = "en";
		Atk14Locale::Initialize($lang);

		$this->assertEquals("Strong",$ts->getContent());
		$this->assertEquals("Strong",$ts->getContent("en"));
		$this->assertEquals("Silná",$ts->getContent("cs"));
		$this->assertEquals("Strong","$ts");

		$lang = "cs";
		Atk14Locale::Initialize($lang);

		$this->assertEquals("Silná",$ts->getContent());
		$this->assertEquals("Strong",$ts->getContent("en"));
		$this->assertEquals("Silná",$ts->getContent("cs"));
		$this->assertEquals("Silná","$ts");

		$this->assertEquals("Silná",$ts->getRawContent());
		$this->assertEquals("Strong",$ts->getRawContent("en"));
		$this->assertEquals("Strong",$ts->getRawContent("en"));

		//

		$ts = $this->technical_specifications["coffee__decaffeinated"];

		$this->assertEquals("No",$ts->getContent("en"));
		$this->assertEquals("Ne",$ts->getContent("cs"));
		$this->assertTrue(false === $ts->getRawContent());
	}
}
