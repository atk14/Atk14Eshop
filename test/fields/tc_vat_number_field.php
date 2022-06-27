<?php
class TcVatNumberField extends TcBase {

	function test(){
		$this->field = new VatNumberField([]);

		// Valid VAT numbers
		foreach([
			"CZ 12345678" 			=> "CZ12345678",
			"cz 123456789"			=> "CZ123456789",
			"Cz 123 456 7890"		=> "CZ1234567890",
			
			// Spain - ES + 9 digits (first and last can be letters)
			"ES X1234567X"			=> "ESX1234567X",
			"esx12345678"				=> "ESX12345678",
			"ES 123 456 789"		=> "ES123456789",

			// Austria
			"ATU69231379"				=> "ATU69231379",

			"LT 100001231746"		=> "LT100001231746",
		] as $input => $cleaned){
			$value = $this->assertValid($input);
			$this->assertEquals($cleaned,(string)$value);
		}

		// Invalid VAT numbers
		foreach([
			"CZ12345678x",
			"CZ123456789012",

			"ES 1234567890",

			"AT169231379",
		] as $input){
			$err = $this->assertInvalid($input);
			$this->assertEquals("VAT number is incorrect",$err);
		}
	}
}
