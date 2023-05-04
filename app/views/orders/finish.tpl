{render partial="shared/checkout_navigation"}

{if $order && $order->isPaid()}

	{capture assign=page_title}<span class="text-success">{!"check"|icon}</span> {t}Objednávka byla zaplacena{/t}{/capture}
	{capture assign=teaser}{t}Děkujeme...{/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

{elseif $payment_transaction && !$payment_transaction->started()}

	{capture assign=page_title}{t}Děkujeme za Váš nákup{/t}{/capture}
	{capture assign=teaser}{t}Za okamžik budete přesměrováni na platební bránu.{/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	<p>
		{t 1=$order->getPaymentTransactionStartUrl()|h escape=false}V případě, že k přesměrování nedojde, <a href="%1">klikněte zde</a>.{/t}
	</p>

	{content for="head"}
		<meta http-equiv="refresh" content="4;url={$order->getPaymentTransactionStartUrl()}" />
	{/content}

{elseif $payment_transaction && $payment_transaction->pending()}

{elseif $payment_transaction && $payment_transaction->cancelled()}
	
	{capture assign=page_title}{t}Platba nebyla uskutečněna{/t}{/capture}
	{capture assign=teaser}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	<p>{t url=$order->getPaymentTransactionStartUrl() escape=no}Pro opakování online platby <a href="%1">klikně zde</a>. V případě přetrvávajících potíží můžete objednávku uhradit bankovním převodem.{/t}</p>
	
	<h4>{t}Platební údaje pro uhrazení objednávky bankovním převodem{/t}</h4>
	{render partial=bank_transfer_data}

{else}

	{capture assign=page_title}{t}Děkujeme{/t}{/capture}
	{capture assign=teaser}{t}…za Váš nákup, vraťte se brzy :){/t}{/capture}

	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	{if $order && $order->getPaymentMethod()->isBankTransfer()}
		<h4>{t}Platební údaje pro uhrazení objednávky{/t}</h4>
		{render partial=$bank_transfer_data}
	{/if}

{/if}
