	{capture assign=page_title}{t}Děkujeme{/t}{/capture}
	{capture assign=teaser}{t}…za Váš nákup, vraťte se brzy :){/t}{/capture}
	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	{* TODO: Zakomentovavame fb tlacitko - nemame totiz verejny detail
	<p class="lead">{t}Pochlubte se přátelům s Vaším nákupem.{/t}</p>
	<div>
		<a href="#" class="btn btn--social-fb">{t}Sdílet{/t}</a>
	</div>
	*}

	{if $order && $order->getPaymentMethod()->isBankTransfer()}
		{assign bank_account $order->getRegion()->getBankAccount()}
		<h4>{t}Platební údaje pro uhrazení objednávky{/t}</h4>
		<strong>{t}Částka k úhradě:{/t}</strong> {!$order->getPriceToPay()|display_price:"$currency,summary"}
		<br>
		<strong>{t}Číslo účtu:{/t}</strong> {$bank_account->getAccountNumber()}
		<br>
		{if $bank_account->getIban()}
			<strong>IBAN:</strong> {$bank_account->getIban()}
			<br>
		{/if}
		{if $bank_account->getSwiftBic()}
			<strong>SWIFT:</strong> {$bank_account->getSwiftBic()}
			<br>
		{/if}
		<strong>{t}Variabilní symbol:{/t}</strong> {$order->getOrderNo()}
		<br>
		{if $bank_account->getHolderName()}
			<strong>{t}Majitel účtu:{/t}</strong> {$bank_account->getHolderName()}
			<br>
		{/if}

		<img src="{link_to namespace="" action="payment_qr_codes/detail" order_token=$order->getToken(["extra_salt" => "QrPayment","hash_length" => 16])}" width="200" height="200" class="pull-right img-responsive">
		<br>Zaplaťte objednávku pomocí QR kódu
	{/if}
