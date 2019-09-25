{assign currency $order->getCurrency()}
{assign delivery_method $order->getDeliveryMethod()}
{assign payment_method $order->getPaymentMethod()}
{assign responsible_user $order->getResponsibleUser()}
{assign order_status $order->getOrderStatus()}
<tr>
	<td>{a action=detail id=$order}{$order->getOrderNo()}{/a}</td>
	<td>{$order->getCreatedAt()|format_datetime}</td>
	<td>{if $order->getInvoiceCompany()}{$order->getInvoiceCompany()}, {/if}{$order->getInvoiceName()}<br>
	<span style="white-space:nowrap;">{t 1=$order->getEmail() escape=false}%1{/t}</span><br>
	{t 1=$order->getPhones()|join:", " escape=false}%1{/t}</td>
	<td>{!$delivery_method}<hr>{!$payment_method}</td>
	<td class="text-right">{!$order->getPriceToPay()|display_price:"$currency,summary"}</td>
	<td>
		{if $order_status->finishedSuccessfully()}
			<span class="text-success">{!"check"|icon} <strong>{$order->getOrderStatus()}</strong></span>
		{elseif $order_status->finishedUnsuccessfully()}
			<span class="text-danger">{!"times"|icon} <strong>{$order->getOrderStatus()}</strong></span>
		{else}
			{$order->getOrderStatus()|lower}
		{/if}
		<br><em>({$order->getOrderStatusSetAt()|humanize_date})</em>
	</td>
	<td>
		{if $order->getAllNotes()}<span title="{$order->getAllNotes()|join:"\n\n"}" class="label label-warning">{!"question-sign"|icon}</span>{/if}
	</td>
	<td>
		{$order->getUpdatedAt()|format_datetime|default:$mdash}
		{if $order->getUpdatedByUser()}
			<br><em>({$order->getUpdatedByUser()})</em>
		{/if}
	</td>
	<td>
		{if $responsible_user}{$responsible_user}{else}{a action="set_responsible_user" id=$order}{t}určit zodp.osobu{/t}{/a}{/if}
	</td>
	<td>
		{dropdown_menu}
			{a action="orders/detail" id=$order}{!"eye"|icon} {t}Detail{/t}{/a}
			{a action="orders/edit" id=$order}{!"edit"|icon} {t}Upravit{/t}{/a}
			{a action="orders/set_responsible_user" id=$order}{!"user"|icon} {t}Přiřadit zodpovědnou osobu{/t}{/a}
			{if $order->getAllowedNextOrderStatuses()}
				{a action="order_order_statuses/create_new" order_id=$order}{!"tasks"|icon} {t}Nastavit nový stav objednávky{/t}{/a}
			{/if}
		{/dropdown_menu}
	</td>
</tr>
