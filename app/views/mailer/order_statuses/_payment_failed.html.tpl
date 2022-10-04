{render partial="thanks_for_order.html"}
<strong>{t order_no=$order->getOrderNo()}Platba za objednávku s označením %1 selhala.{/t}</strong>

{assign payment_transaction $order->getPaymentTransaction()}
{if $payment_transaction && $payment_transaction->isRepeatable()}
	<br/>
	<br/>
	{capture assign=payment_transaction_link}<a href="{$order->getPaymentTransactionStartUrl()}" style="{$link_style}">{$order->getPaymentTransactionStartUrl()}</a>{/capture}
	{t payment_transaction_link=$payment_transaction_link escape=no}Pro opakování platby přejděte na adresu %1{/t}
{/if}
