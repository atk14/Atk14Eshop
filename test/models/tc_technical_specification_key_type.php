<?php
class TcTechnicalSpecificationKeyType extends TcBase {

	function test(){
		$type = TechnicalSpecificationKeyType::GetInstanceByCode("text");
		$this->assertEquals("Text",$type->getName());
		$this->assertNull($type->getTransformator());

		$type = TechnicalSpecificationKeyType::GetInstanceByCode("integer");
		$this->assertEquals("Integer number",$type->getName());
		$this->assertEquals("Číslo celočíselné",$type->getName("cs"));
		$transformator = $type->getTransformator();
		$this->assertTrue(is_a($transformator,"TechnicalSpecificationKeyType_Integer"));
	}
}
