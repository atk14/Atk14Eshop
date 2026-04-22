<?php
/**
 *
 * @fixture vouchers
 * @fixture regions
 * @fixture users
 */
class TcVouchers extends TcBase {

	function test(){
		$voucher = $this->vouchers["gift_coupon_500"];
		$region = $this->regions["CR"];

		// Localhost
		$this->client->setRemoteAddr("127.0.0.1");
		//
		$this->client->get("vouchers/detail",[
			"token" => $voucher->getToken("voucher_detail"),
			"id" => $voucher->getId(),
			"region_id" => $region,
			"format" => "html",
		]);
		$this->assertEquals(200,$this->client->getStatusCode());

		// Potentially dangerous place on the Internet
		$this->client->setRemoteAddr("8.8.8.8");
		//
		$this->client->get("vouchers/detail",[
			"token" => $voucher->getToken("voucher_detail"),
			"id" => $voucher->getId(),
			"region_id" => $region,
			"format" => "html",
		]);
		$this->assertEquals(403,$this->client->getStatusCode());

		// Administrator is able to see the voucher
		$this->client->post("logins/create_new",[
			"login" => "admin",
			"password" => "admin",
		]);
		$this->assertEquals(303,$this->client->getStatusCode());
		//
		$this->client->get("vouchers/detail",[
			"token" => $voucher->getToken("voucher_detail"),
			"id" => $voucher->getId(),
			"region_id" => $region,
			"format" => "html",
		]);
		$this->assertEquals(200,$this->client->getStatusCode());

		$this->client->post("logins/destroy");

		// Non-administrator is not able to see the voucher
		$this->client->post("logins/create_new",[
			"login" => "rambo",
			"password" => "secret",
		]);
		$this->assertEquals(303,$this->client->getStatusCode());
		//
		$this->client->get("vouchers/detail",[
			"token" => $voucher->getToken("voucher_detail"),
			"id" => $voucher->getId(),
			"region_id" => $region,
			"format" => "html",
		]);
		$this->assertEquals(403,$this->client->getStatusCode());
	}
}
