<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture warehouse_items
 * @fixture baskets
 * @fixture basket_items
 * @fixture delivery_methods
 * @fixture delivery_services
 * @fixture delivery_service_branches
 * @fixture payment_methods
 * @fixture shipping_combinations
 */
class TcCheckouts extends TcBase {

	function setUp() {
		parent::setUp();

		# set API_KEY to activate Zasilkovna
		SystemParameter::CreateNewRecord([
			"code" => "delivery_services.zasilkovna.api_key",
			"content" => "some-api-key",
			"system_parameter_type_id" => 1,
		]);
	}

	function test_post_set_payment_and_delivery_method_with_branch() {
		global $HTTP_REQUEST;
		global $ATK14_GLOBAL;
		$HTTP_REQUEST->setRemoteAddr("127.0.0.1");
		$client = $this->client;
		$lang = $ATK14_GLOBAL->getDefaultLang();

		$this->_setup_basket();

		$controller = $client->get("checkouts/set_payment_and_delivery_method");
		$basket = $controller->_get_basket(true);
		$this->assertFalse($basket->isEmpty());


		$controller = $client->post("delivery_service_branches/set_branch", [
			"delivery_method_id" => $this->delivery_methods["zasilkovna"]->getId(),
			"delivery_service_branch_id" => $this->delivery_service_branches["zasilkovna_1"]->getExternalBranchId(),
			"_return_uri_" => Atk14Url::BuildLink(["action" => "checkouts/set_payment_and_delivery_method"]),
		]);

		$this->assertEquals(303, $client->getStatusCode());
		$this->assertEmpty($controller->form->get_errors());
		$this->assertEquals("/{$lang}/checkouts/set_payment_and_delivery_method/", ($client->getLocation()));
	}

	function test_post_set_payment_and_delivery_method_without_branch() {
		Cache::Clear();
		global $HTTP_REQUEST;
		$HTTP_REQUEST->setRemoteAddr("127.0.0.1");
		$client = $this->client;

		$this->_setup_basket();

		$controller = $client->post("checkouts/set_payment_and_delivery_method", [
			"delivery_method_id" => $this->delivery_methods["zasilkovna"]->getId(),
			"payment_method_id" => $this->payment_methods["bank_transfer"]->getId(),
		]);

		$this->assertEquals(200, $client->getStatusCode());

		$this->assertNotEmpty($errors = $controller->form->errors);
		$this->assertArrayHasKey("delivery_method_id", $errors);
		$this->assertEquals(_("Choose pickup place for selected delivery method"), $errors["delivery_method_id"][0]);
	}

	protected function _setup_basket() {
		$client = $this->client;
		$controller = $client->get("main/index");

		$controller->permanentSession->s("basket_id", $this->baskets["anonymous"]->getId());
		$client->addCookie(new HttpCookie("permanent", $controller->permanentSession->getSecretToken()));
	}
}
