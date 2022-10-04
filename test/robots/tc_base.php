<?php
class TcBase extends TcAtk14Robot {

	function setUp(){
		$this->dbmole->begin();
		$this->setUpFixtures();
	}

	function tearDown(){
		$this->dbmole->rollback();
	}
}
