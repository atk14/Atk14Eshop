{capture assign=page_title}{t}Historie a detaily mých objednávek{/t}{/capture}
{assign payment_transaction $order->getPaymentTransaction()}
{capture assign=order_status}
	<ul class="list-bullets">
		<li>{t date=$order->getCreatedAt()|format_datetime}Objednávka vytvořena: %1{/t}</li>
		{if $payment_transaction}
			<li>{t status=$payment_transaction->getPaymentStatus()|default:"?"}Stav platby: %1{/t}</li>
		{/if}
	</ul>
{/capture}
{render partial="shared/layout/content_header" title=$page_title teaser=$order_status}

{render partial="shared/order_detail" user=$order->getUser()}