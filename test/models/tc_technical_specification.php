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

	function test_autoparsing_raw_value(){
		// ### Type: Integer

		// auto-parsing integer value succeeded
		$ts = TechnicalSpecification::CreateNewRecord(array(
			"card_id" => $this->cards["book"],
			"technical_specification_key_id" => $this->technical_specification_keys["width"],
			"content" => "12",
		));
		$this->assertEquals('{"integer":12}',$ts->getContentJson());

		// auto-parsing integer value failed
		$ts = TechnicalSpecification::CreateNewRecord(array(
			"card_id" => $this->cards["fridge"],
			"technical_specification_key_id" => $this->technical_specification_keys["width"],
			"content" => "Its' too heavy",
		));
		$this->assertNull($ts->getContentJson());

		// auto-parsing integer value not desired
		$ts = TechnicalSpecification::CreateNewRecord(array(
			"card_id" => $this->cards["peanuts"],
			"technical_specification_key_id" => $this->technical_specification_keys["width"],
			"content" => "12",
			"content_json" => null,
		));
		$this->assertNull($ts->getContentJson());
	}

	function test_CreateNewRecord(){
		$lang = "en";
		Atk14Locale::Initialize($lang);

		// ### Type: Integer

		$ts = TechnicalSpecification::CreateNewRecord(array(
			"card_id" => $this->cards["book"],
			"technical_specification_key_id" => $this->technical_specification_keys["width"],
			"content" => "12",
		));
		$this->assertEquals('{"integer":12}',$ts->getContentJson());
		$this->assertEquals(null,$ts->g("content")); // in this case, there is no need to store the content
		$this->assertEquals("12",$ts->getContent());

		$ts = TechnicalSpecification::CreateNewRecord(array(
			"card_id" => $this->cards["wooden_button"],
			"technical_specification_key_id" => $this->technical_specification_keys["width"],
			"content" => "1 cm",
		));
		$this->assertEquals('{"integer":1}',$ts->getContentJson());
		$this->assertEquals("1 cm",$ts->g("content")); // in this case, the content must be stored
		$this->assertEquals("1 cm",$ts->getContent());

		// ### Type: Boolean

		$ts = TechnicalSpecification::CreateNewRecord(array(
			"card_id" => $this->cards["tea"],
			"technical_specification_key_id" => $this->technical_specification_keys["decaffeinated"],
			"content" => "Yes",
		));
		$this->assertEquals('{"boolean":true}',$ts->getContentJson());
		$this->assertEquals(null,$ts->g("content")); // in this case, there is no need to store the content
		$this->assertEquals("Yes",$ts->getContent());
	}

	function test_CreateForCard(){
		$book = $this->cards["book"];
		$peanuts = $this->cards["peanuts"];

		$this->assertEquals(null,$book->getTechnicalSpecification("pages"));
		$this->assertEquals(null,$book->getTechnicalSpecification("isbn"));
		//
		$this->assertEquals(null,$peanuts->getTechnicalSpecification("pages"));
		$this->assertEquals(null,$peanuts->getTechnicalSpecification("isbn"));

		TechnicalSpecification::CreateForCard($book,"pages","222");

		$this->assertEquals("222",$book->getTechnicalSpecification("pages"));
		$this->assertEquals(null,$book->getTechnicalSpecification("isbn"));
		//
		$this->assertEquals(null,$peanuts->getTechnicalSpecification("pages"));
		$this->assertEquals(null,$peanuts->getTechnicalSpecification("isbn"));

		TechnicalSpecification::CreateForCard($book,"isbn","11-22-33-44");

		$this->assertEquals("222",(string)$book->getTechnicalSpecification("pages"));
		$this->assertEquals("11-22-33-44",(string)$book->getTechnicalSpecification("isbn"));
		//
		$this->assertEquals(null,$peanuts->getTechnicalSpecification("pages"));
		$this->assertEquals(null,$peanuts->getTechnicalSpecification("isbn"));
	}
}
