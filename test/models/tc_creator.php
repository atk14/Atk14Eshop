<?php
/**
 *
 * @fixture creators
 */
class TcCreator extends TcBase {

	function test_getName(){
		// Team of authaors

		$team_of_authors = $this->creators["team_of_authors"];
		$this->assertEquals("team of authors",$team_of_authors->getName());
		$this->assertEquals("team of authors",$team_of_authors->getName("en"));
		$this->assertEquals("kolektiv autorů",$team_of_authors->getName("cs"));
		$this->assertEquals("team_of_authors",$team_of_authors->getName(false));
		$this->assertEquals("team_of_authors",$team_of_authors->getName(false,"cs"));

		$lang = "cs";
		Atk14Locale::Initialize($lang);

		$this->assertEquals("kolektiv autorů",$team_of_authors->getName());
		$this->assertEquals("team_of_authors",$team_of_authors->getName(false));
		$this->assertEquals("kolektiv autorů",$team_of_authors->getName(true));
		$this->assertEquals("team of authors",$team_of_authors->getName(true,"en"));

		// John Doe

		$john_doe = $this->creators["john_doe"];
		$this->assertEquals("John Doe",$john_doe->getName());
		$this->assertEquals("John Doe",$john_doe->getName("en"));
		$this->assertEquals("John Doe",$john_doe->getName("cs"));
		$this->assertEquals("John Doe",$john_doe->getName(false));
		$this->assertEquals("John Doe",$john_doe->getName(true,"en"));
	}
}
