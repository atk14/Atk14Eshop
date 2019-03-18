<h2>{$page_title}</h2>

{assign payment_transaction $order->getPaymentTransaction()}

<ul>
	<li>{t date=$order->getCreatedAt()|format_datetime}Objednávka vytvořena: %1{/t}</li>
	{if $payment_transaction}
		<li>{t status=$payment_transaction->getPaymentStatus()|default:"?"}Stav platby: %1{/t}</li>
	{/if}
</ul>

{render partial="shared/order_detail" user=$order->getUser()}
