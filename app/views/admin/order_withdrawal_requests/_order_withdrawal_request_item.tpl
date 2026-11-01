{assign order $order_withdrawal_request->getOrder()}

<tr>
	{highlight_search_query}
	<td>{$order_withdrawal_request->getId()}</td>
	<td>{a action="orders/detail" id=$order}{$order->getOrderNo()}{/a}</td>
	<td>{$order_withdrawal_request->getFirstname()} {$order_withdrawal_request->getLastname()}</td>
	<td>{$order_withdrawal_request->getEmail()}</td>
	<td>{$order_withdrawal_request->getPhone()|display_phone}</td>
	{/highlight_search_query}
	<td>{$order_withdrawal_request->getCreatedAt()|format_datetime}</td>
	<td>
		{dropdown_menu}
			{a action="detail" id=$order_withdrawal_request}{!"eye-open"|icon} {t}Detail{/t}{/a}
		{/dropdown_menu}
	</td>
</tr>
