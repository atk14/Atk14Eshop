{render partial="shared/checkout_navigation"}

{if $order && $order->isPaid()}

	{*** The order has already been paid ***}

	{capture assign=page_title}<span class="text-success">{!"circle-check"|icon}</span> {t}Objednávka byla zaplacena{/t}{/capture}
	{capture assign=teaser}{t}Děkujeme...{/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

{elseif $payment_transaction && !$payment_transaction->started()}

	{*** The payment transaction has not yet been started  ***}

	{capture assign=page_title}{t}Děkujeme za Váš nákup{/t}{/capture}
	{capture assign=teaser}{t}Za okamžik budete přesměrováni na platební bránu.{/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	<p>
		{t 1=$order->getPaymentTransactionStartUrl()|h escape=false}V případě, že k přesměrování nedojde, <a href="%1">klikněte zde</a>.{/t}
	</p>

	{content for="head"}
		<meta http-equiv="refresh" content="4;url={$order->getPaymentTransactionStartUrl()}" />
	{/content}

{elseif $payment_transaction && $payment_transaction->started() && ($payment_transaction->pending() || !$payment_transaction->getPaymentStatus())}

	{*** The payment transaction is a pending or unknown state ***}
 
	{capture assign=page_title}{t}Čekáme na dokončení platby{/t}{/capture}
	{capture assign=teaser}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	<p>
		{t url=$order->getPaymentTransactionStartUrl() escape=no}Pro vstup do platební transakce <a href="%1">klikněte zde</a>.{/t}
	</p>

	{if "OFFER_BANK_TRANSFER_IF_ONLINE_TRANSACTION_FAILS"|constant}
		{render partial=bank_transfer_data title="" leading_text="{t}Pokud se Vám nedaří dokončit online platbu, uhraďte objednávku bankovním převodem.{/t}"}
	{/if}

{elseif $payment_transaction && $payment_transaction->cancelled()}

	{*** The payment transaction has been cancelled ***}
	 
	{capture assign=page_title}{t}Platba nebyla uskutečněna{/t}{/capture}
	{capture assign=teaser}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	{if $payment_transaction->isRepeatable()}
		<p>{t url=$order->getPaymentTransactionStartUrl() escape=no}Pro opakování online platby <a href="%1">klikně zde</a>.{/t}</p>
		{assign leading_text "{t}V případě přetrvávajících potíží můžete objednávku uhradit bankovním převodem.{/t}"}
	{else}
		<p>{t}Opakování online platby již není možné.{/t}</p>
		{assign leading_text "{t}Objednávku však můžete uhradit bankovním převodem.{/t}"}
	{/if}
	
	{if "OFFER_BANK_TRANSFER_IF_ONLINE_TRANSACTION_FAILS"|constant}
		{render partial=bank_transfer_data title="{t}Platební údaje pro uhrazení objednávky bankovním převodem{/t}" leading_text=$leading_text}
	{/if}	

{else}

	{*** A generic finish screen  ***}

	{capture assign=page_title}{t}Děkujeme{/t}{/capture}
	{capture assign=teaser}{t}…za Váš nákup, vraťte se brzy :){/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	{if $order && $order->getPaymentMethod()->isBankTransfer()}
		{render partial=bank_transfer_data title="{t}Platební údaje pro uhrazení objednávky{/t}" leading_text=""}
	{/if}

{/if}
