<h2>{$page_title}</h2>

{assign payment_transaction $order->getPaymentTransaction()}

<ul>
	<li>{t date=$order->getCreatedAt()|format_datetime}Objednávka vytvořena: %1{/t}</li>
	{if $payment_transaction}
		<li>{t status=$payment_transaction->getPaymentStatus()|default:"?"}Stav platby: %1{/t}</li>
	{/if}

	{* "Ošetřovací symboly" nahrazuje odkaz "Přehled objednaného zboží"
	{if $contains_product_with_care_instructions}
		<li>{a action="care_instructions/index" order_token=$order->getToken()}{t}Ošetřovací instrukce{/t}{/a}</li>
	{/if}
	*}

	<li>{a action="ordered_products/index" order_token=$order->getToken()}{t}Přehled objednaného zboží s ošetřovacími symboly{/t}{/a}</li>
</ul>

{render partial="shared/order_detail" user=$order->getUser()}
