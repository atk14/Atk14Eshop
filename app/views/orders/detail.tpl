{assign payment_transaction $order->getPaymentTransaction()}
{capture assign=order_status}
	<ul class="list-unstyled">
		<li>{t date=$order->getCreatedAt()|format_datetime}objednávka vytvořena: %1{/t}</li>
		<li>{t}stav objednávky:{/t} {render partial="shared/order_status" order=$order lowerize=true}</li>
		{if $payment_transaction}
			<li>{t status=$payment_transaction->getPaymentStatus()|default:"?"}stav platby: %1{/t}</li>
		{/if}
	</ul>
{/capture}
{render partial="shared/layout/content_header" title=$page_title teaser=$order_status}

{render partial="shared/order_detail" user=$order->getUser()}
