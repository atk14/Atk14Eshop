<h1>{$page_title}</h1>

{if !$payment_transaction}

	<p>{a action="main/index"}{t}Přejděte na úvodní stránku{/t}{/a}</p>

{else}

	{assign order $payment_transaction->getOrder()}

	<p>
		{t}Stav platby:{/t}	{$payment_transaction->getPaymentStatus()|default:"?"}<br>
		{t}Objednávka:{/t} {a action="orders/detail" token=$order->getToken()}{$order->getOrderNo()}{/a}
	</p>

{/if}


