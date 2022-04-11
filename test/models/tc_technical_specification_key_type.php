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

	function test_parseValue(){
		$this->_parseValue("integer",[
			["123",			123],
			["+11",			11],
			["-12",			-12],
			["- 10",		-10],
			["1234 kg",	1234],
			["123 456",	123456],
			["34KG",		34],
			["12 g/m2", 12],
			["0",				0],
			["unknown",	null],
		]);

		$this->_parseValue("boolean",[
			["yes",							true],
			["Yes",							true],
			["true",						true],
			["1",								true],
			["ANO",							true],

			["no",							false],
			["No",							false],
			["false",						false],
			["0",								false],
			["NE",							false],

			["unknown",					null],
			["True of false?",	null],
		]);
	}

	function _parseValue($type_code,$ary){
		$type = TechnicalSpecificationKeyType::GetInstanceByCode($type_code);
		$transformator = $type->getTransformator();
		foreach($ary as $item){
			list($str_value,$expected) = $item;
			echo "$str_value -> $expected\n";
			$this->assertEquals($expected,$transformator->parseValue($str_value),"[$type_code] $str_value should be converted to ".var_export($expected,true));
			$this->assertTrue($expected === $transformator->parseValue($str_value),"[$type_code] $str_value should be converted to ".var_export($expected,true));
		}
	}
}
