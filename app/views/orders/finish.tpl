{render partial="shared/checkout_navigation"}

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
		{assign currency $order->getCurrency()}
		<strong>{t}Částka k úhradě:{/t}</strong> {!$order->getPriceToPay()|display_price:"$currency,summary"}
		<br>
		<strong>{t}Variabilní symbol:{/t}</strong> {$order->getOrderNo()}
		<br>
		<strong>{t}Číslo účtu:{/t}</strong> {$bank_account->getAccountNumber()}
		{if $bank_account->getIban()}
			<br>
			<strong>IBAN:</strong> {$bank_account->getIban()}
		{/if}
		{if $bank_account->getSwiftBic()}
			<br>
			<strong>SWIFT:</strong> {$bank_account->getSwiftBic()}
		{/if}
		{if $bank_account->getHolderName()}
			<br>
			<strong>{t}Majitel účtu:{/t}</strong> {$bank_account->getHolderName()}
		{/if}
		
		{if constant("PAYMENT_QR_CODES_ENABLED")}
			<br>
			<img src="{link_to namespace="" action="payment_qr_codes/detail" order_token=$order->getToken(["extra_salt" => "QrPayment","hash_length" => 16])}" width="200" height="200" class="pull-right img-responsive">
		{/if}
	{/if}
