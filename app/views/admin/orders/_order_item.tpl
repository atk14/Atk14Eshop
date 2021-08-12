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
	{t 1=", "|join:$order->getPhones() escape=false}%1{/t}</td>
	<td>{!$delivery_method}<hr>{!$payment_method}</td>
	<td class="text-right">{!$order->getPriceToPay()|display_price:"$currency,summary"}</td>
	<td>
		{render partial="shared/order_status"}
		<br><em>({$order->getOrderStatusSetAt()|humanize_date})</em>
	</td>
	<td>
		{if $order->getAllNotes()}<span title="{"\n\n"|join:$order->getAllNotes()}" class="badge badge-warning">{!"question"|icon}</span>{/if}
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
				{a action="order_order_statuses/create_new" order_id=$order}{!"level-up-alt"|icon} {t}Změnit stav objednávky{/t}{/a}
			{/if}
		{/dropdown_menu}
	</td>
</tr>
