<?php
class TcVoucher extends TcBase {

	function test_PrepareVoucherCode(){
		$code1 = Voucher::PrepareVoucherCode(["length" => 10]);
		$code2 = Voucher::PrepareVoucherCode(["length" => 10]);

		$this->assertEquals(10,strlen($code1));
		$this->assertEquals(10,strlen($code2));

		$this->assertNotEquals($code1,$code2);

		$code3 = Voucher::PrepareVoucherCode(["length" => 12]);
		$code4 = Voucher::PrepareVoucherCode(["length" => 12]);

		$this->assertEquals(12,strlen($code3));
		$this->assertEquals(12,strlen($code4));

		$this->assertNotEquals($code3,$code4);
	}
}
