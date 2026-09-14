<?php
/**
 * @fixture orders
 */
class TcOrderWithdrawalRequests extends TcBase {

	function test(){
		$client = $this->client;
		$order = $this->orders["test"];

		$order_already_withdrawn = $this->orders["test_anonymous"];
		OrderWithdrawalRequest::CreateNewRecord([
			"order_id" => $order_already_withdrawn,
		]);

		$order_too_old = $this->orders["test_bank_transfer"];
		$order_too_old->s("created_at","2025-09-14 23:20:00");

		// ### Zadani cisla objednavky

		// spatne cislo objednavky
		$ctrl = $client->post("order_withdrawal_requests/create_new",[
			"order_no" => "XXXX",
		]);
		$this->assertEquals(200,$client->getStatusCode());
		$this->assertEquals([_("Taková objednávka neexistuje")],array_flatten($ctrl->form->get_errors()));
		// spravne cislo, ale objednavka uz zadost ma
		$ctrl = $client->post("order_withdrawal_requests/create_new",[
			"order_no" => $order_already_withdrawn->getOrderNo(),
		]);
		$this->assertEquals(200,$client->getStatusCode());
		$this->assertEquals([_("Pro tuto objednávku již evidujeme žádost o odstoupení od smlouvy.")],array_flatten($ctrl->form->get_errors()));
		// spravne cislo, ale objednavka je prilis stara
		$ctrl = $client->post("order_withdrawal_requests/create_new",[
			"order_no" => $order_too_old->getOrderNo(),
		]);
		$this->assertEquals(200,$client->getStatusCode());
		$this->assertEquals([_("Objednávku již není možné vrátit.")],array_flatten($ctrl->form->get_errors()));
		// spravne cislo, spravny stav
		$order->setNewOrderStatus("ready_for_pickup");
		$ctrl = $client->post("order_withdrawal_requests/create_new",[
			"order_no" => $order->getOrderNo(),
		]);
		$this->assertEquals(303,$client->getStatusCode());
		$this->assertEquals(false,$ctrl->form->has_errors());

		// ### Odeslani emailu s kodem

		$location = $client->getLocation();
		//
		$client->get($location);
		$this->assertStringContains("vám zašleme jednorázový číselný kód, kterým potvrdíte vlastnictví objednávky",$client->getContent());
		//
		$ctrl = $client->post($location);
		$this->assertEquals(303,$client->getStatusCode());
		$this->assertEquals("john@rambo.cz",$ctrl->mailer->to);
		$this->assertStringContains("zadejte do formuláře tento jednorázový kód",$ctrl->mailer->body_html);
		preg_match('/<strong>(\d+)<\/strong>/',$ctrl->mailer->body_html,$matches);
		$otp_code = $matches[1];

		// ### Zadani hesla

		$location = $client->getLocation();
		$client->get($location);
		$this->assertStringContains("Do formuláře zadejte číselný kód, který vám byl zaslán",$client->getContent());
		// spatny kod
		$ctrl = $client->post($location,["code" => "123456"]);
		$this->assertEquals(200,$client->getStatusCode());
		$this->assertEquals(["Toto není platný kód"],array_flatten($ctrl->form->get_errors()));
		// spravny kod
		$client->post($location,["code" => $otp_code]);
		$this->assertEquals(303,$client->getStatusCode());

		// ### Formular pro odstoupeni od smlouvy

		$location = $client->getLocation();
		$client->get($location);
		$this->assertStringContains("Odesláním tohoto formuláře podáte žádost na odstoupení od kupní smlouvy k objednávce",$client->getContent());
	}
}
