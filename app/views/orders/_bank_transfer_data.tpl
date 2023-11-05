{assign currency $order->getCurrency()}
{assign bank_account $order->getBankAccount()}

{if $bank_account}

	{if $leading_text}
		<p>{$leading_text}</p>
	{/if}

	{if $title}
		<h4>{$title}</h4>
	{/if}

	<strong>{t}Částka k úhradě:{/t}</strong> {!$order->getPriceToPay()|display_price:"$currency,summary=auto"}
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
