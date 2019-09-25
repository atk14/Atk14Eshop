{assign currency $order->getCurrency()}
{assign order_status $order->getOrderStatus()}

<tr>
	<td>{a action="orders/detail" id=$order}{$order->getOrderNo()}{/a}</td>
	<td>
		{if $order_status->finishedSuccessfully()}
			<span class="text-success">{!"check"|icon} {$order->getOrderStatus()|lower}</span>
		{elseif $order_status->finishedUnsuccessfully()}
			<span class="text-danger">{!"times"|icon} {$order->getOrderStatus()|lower}</span>
		{else}
			<span class="text-secondary">{$order->getOrderStatus()|lower}</span>
		{/if}
	</td>
	<td>{$order->getCreatedAt()|format_date}</td>
	<td class="text-right">{!$order->getPriceToPay()|display_price:"$currency,summary"}</td>
	{* <td>{a}{t}Faktura{/t} #######{/a}</td> *}
</tr>
