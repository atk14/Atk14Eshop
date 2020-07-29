<?php
/**
 *
 * @fixture creators
 * @fixture card_creators
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

	function test_getRoles_getCards(){
		$john_doe = $this->creators["john_doe"];
		$samantha_doe = $this->creators["samantha_doe"];
		$team_of_authors = $this->creators["team_of_authors"];

		$role_author = CreatorRole::GetInstanceByCode("author");
		$role_illustration = CreatorRole::GetInstanceByCode("illustration");
		$role_artist = CreatorRole::GetInstanceByCode("artist");

		$roles = $john_doe->getRoles();
		$this->assertEquals(1,sizeof($roles));
		$this->assertEquals($role_author->getId(),$roles[0]->getId());

		$roles = $samantha_doe->getRoles();
		$this->assertEquals(1,sizeof($roles));
		$this->assertEquals($role_illustration->getId(),$roles[0]->getId());

		$roles = $team_of_authors->getRoles();
		$this->assertEquals(0,sizeof($roles));

		$cards = $john_doe->getCards($role_author);
		$this->assertEquals(1,sizeof($cards));

		$cards = $john_doe->getCards();
		$this->assertEquals(1,sizeof($cards));

		$cards = $john_doe->getCards($role_illustration);
		$this->assertEquals(0,sizeof($cards));
	}
}
