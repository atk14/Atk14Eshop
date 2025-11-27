<?php
/**
 * @fixture orders
 * @fixture users
 */
class TcOrders extends TcBase {

	function test(){
		$ctrl = $this->client->get("orders/index");
		$this->assertEquals(302,$this->client->getStatusCode());
		$this->assertEquals("To view your orders, log in with your username and password",(string)$ctrl->flash->info());

		$ctrl = $this->client->get("orders/detail",["id" => $this->orders["test"]->getId()]);
		$this->assertEquals(302,$this->client->getStatusCode());
		$this->assertEquals("To view the contents of your order, log in with your username and password",(string)$ctrl->flash->info());

		$this->client->post("logins/create_new",[
			"login" => "rambo",
			"password" => "secret",
		]);
		$this->assertEquals(303,$this->client->getStatusCode());

		$ctrl = $this->client->get("orders/index");
		$this->assertEquals(200,$this->client->getStatusCode());

		$ctrl = $this->client->get("orders/detail",["id" => $this->orders["test"]->getId()]);
		$this->assertEquals(200,$this->client->getStatusCode());

		// not a rambo's order
		$ctrl = $this->client->get("orders/detail",["id" => $this->orders["test_cash_on_delivery"]->getId()]);
		$this->assertEquals(404,$this->client->getStatusCode());
	}
}
