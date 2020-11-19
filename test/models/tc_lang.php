<?php
class TcLang extends TcBase {
	
	function test(){
		$langs = Lang::GetInstances();
		$lang = $langs[0];

		$this->assertEquals("en",$lang->getId());
		$this->assertEquals([
			"id" => "en",
			"LANG" => "en_US.UTF-8",
			"name" => "english"
		],$lang->toArray());
	}
}
