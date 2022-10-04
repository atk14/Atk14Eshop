{render partial="shared/checkout_navigation"}

{capture assign=page_title}{t}Děkujeme{/t}{/capture}
{capture assign=teaser}{t}…za Váš nákup, vraťte se brzy :){/t}{/capture}

{if $order}
	{assign currency $order->getCurrency()}
	{assign bank_account $order->getBankAccount()}

	{capture assign=bank_transfer_data}
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
	{/capture}
{/if}

{if $order && $order->isPaid()}

	{capture assign=page_title}<span class="text-success">{!"check"|icon}</span> {t}Objednávka byla zaplacena{/t}{/capture}
	{capture assign=teaser}{t}Děkujeme...{/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

{elseif $payment_transaction_start_url}

	{assign payment_method $order->getPaymentMethod()}

	{capture assign=page_title}{t}Děkujeme za Váš nákup{/t}{/capture}
	{capture assign=teaser}{t}Za okamžik budete přesměrováni na platební bránu.{/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	<p>
		{t 1=$payment_transaction_start_url|h escape=false}V případě, že k přesměrování nedojde, <a href="%1">klikněte zde</a>.{/t}
	</p>

	{content for="head"}
		<meta http-equiv="refresh" content="4;url={$payment_transaction_start_url}" />
	{/content}

{elseif $order && $order->getPaymentTransaction() && $order->getOrderStatus()->getCode()=="payment_failed"}
	
	{capture assign=page_title}{t}Platba nebyla uskutečněna{/t}{/capture}
	{capture assign=teaser}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	<p>{t url=$order->getPaymentTransactionStartUrl() escape=no}Pro opakování online platby <a href="%1">klikně zde</a>. V případě přetrvávajících potíží můžete objednávku uhradit bankovním převodem.{/t}</p>
	
	<h4>{t}Platební údaje pro uhrazení objednávky bankovním převodem{/t}</h4>
	{!$bank_transfer_data}

{else}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	{if $order && $order->getPaymentMethod()->isBankTransfer()}
		<h4>{t}Platební údaje pro uhrazení objednávky{/t}</h4>
		{!$bank_transfer_data}
	{/if}

{/if}
