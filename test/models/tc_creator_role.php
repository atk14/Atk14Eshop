<?php
/**
 *
 * @fixture creator_roles
 */
class TcCreatorRole extends TcBase {

	function test(){
		$stuntman = $this->creator_roles["stuntman"];

		$this->assertEquals("Stuntman",$stuntman->getName());
		$this->assertEquals("Stuntmans",$stuntman->getPluralName());

		$stuntman->s([
			"plural_name_en" => null,
			"plural_name_cs" => null,
		]);

		$this->assertEquals("Stuntman",$stuntman->getName());
		$this->assertEquals("Stuntman",$stuntman->getPluralName());
	}
}
