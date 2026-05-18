<mj-text>

{render partial="thanks_for_order.html"}
<strong>{t order_no=$order->getOrderNo()}Platba za objednávku s označením %1 selhala.{/t}</strong>
</mj-text>

{assign payment_transaction $order->getPaymentTransaction()}
{if $payment_transaction}
	{capture assign=payment_transactio_url}{link_to namespace="" action="orders/finish" token=$order->getToken() _with_hostname=true _ssl=REDIRECT_TO_SSL_AUTOMATICALLY}{/capture}
	{capture assign=payment_transaction_link}<a href="{$payment_transactio_url}" class="muted">{$payment_transactio_url}</a>{/capture}

	<mj-button href="{$payment_transactio_url}">{t}Opakovat platbu{/t}</mj-button>
	<mj-text>
		<p style="text-align: center;"><small>{t payment_transaction_link=$payment_transaction_link escape=no}Instrukce pro opakování platby najdete na adrese %1{/t}</small></p>
	</mj-text>
{/if}
