{assign currency $order->getCurrency()}
<tr>
	<td>{a action="orders/detail" id=$order}{$order->getOrderNo()}{/a}</td>
	<td>{$order->getCreatedAt()|format_datetime}</td>
	<td>{!$order->getPriceToPay()|display_price:"$currency,summary"}</td>
	<td>{!$order->getOrderStatus()}</td>
</tr>
