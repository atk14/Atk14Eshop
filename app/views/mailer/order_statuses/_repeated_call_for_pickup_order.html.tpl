{render partial="thanks_for_order.html"}
{if $delivery_method->personalPickup()}
	<strong>{t order_no=$order->getOrderNo()}Vaše objednávka č. %1 je připravena k vyzvednutí na výdejním místě{/t} - {!$delivery_method->getEmailDescription()}</strong>
{else}
	<strong>{t order_no=$order->getOrderNo()}Vaše objednávka č. %1 je připravena k odeslání.{/t}</strong>
{/if}
