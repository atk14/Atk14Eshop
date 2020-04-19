<?php
class TcTraitCodebook extends TcBase {

	function test(){
		$cnt_1 = $this->dbmole->getQueriesExecuted();

		SystemParameterType::GetInstanceByCode("test");

		$cnt_2 = $this->dbmole->getQueriesExecuted();

		$this->assertNull(SystemParameterType::GetInstanceByCode("nonexisting"));
		$this->assertNotNull(SystemParameterType::GetInstanceById(1));

		$cnt_3 = $this->dbmole->getQueriesExecuted();

		$this->assertEquals($cnt_2,$cnt_1 + 2);
		$this->assertEquals($cnt_2,$cnt_3);
	}
}
