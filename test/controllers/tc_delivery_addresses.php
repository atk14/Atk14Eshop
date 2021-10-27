<?php
/**
 *
 * @fixture users
 * @fixture regions
 */
class TcDeliveryAddresses extends TcBase {

	function test(){
		$client = $this->client;

		$client->get("delivery_addresses/create_new");
		$this->assertEquals(403,$client->getStatusCode(),"forbidden for non logged-in users");

		$client->post("logins/create_new",[
			"login" => "rambo",
			"password" => "secret",
		]);

		$ctrl = $client->get("delivery_addresses/create_new");
		$this->assertEquals(200,$client->getStatusCode());

		// checking that address_country field contains all countries from all regions
		$choices = $ctrl->form->fields["address_country"]->get_choices();
		$countries = array_keys($choices);
		$this->assertTrue(in_array("CZ",$countries));
		$this->assertTrue(in_array("GR",$countries));
	}
}
