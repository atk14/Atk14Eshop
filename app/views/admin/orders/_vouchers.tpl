<h3 id="vouchers">{button_create_new action="order_vouchers/create_new" order_id=$order return_to_anchor="vouchers"}{/button_create_new} {t}Slevové kupóny{/t}</h3>

{assign order_vouchers $order->getVouchers()}
{assign currency $order->getCurrency()}
{capture assign=return_uri}{$request->getUri()}#vouchers{/capture}

{if !$order_vouchers}

	<p>{t}Slevové kupóny nebyly zadány{/t}</p>

{else}
	
	<table class="table">
		<thead>
			<tr>
				<th>{t}Kód{/t}</th>
				<th>{t}Sleva{/t}</th>
				<th>{t}Poznámka{/t}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $order_vouchers as $order_voucher}
				<tr>
					<td>{$order_voucher}</td>
					<td>{!$order_voucher->getDiscountAmount()|display_price:"$currency"}</td>
					<td>
						{if $order_voucher->createdAdministratively()}
							<em>{t date=$order_voucher->getCreatedAt()|format_date time=$order_voucher->getCreatedAt()|format_date:"H:i" name=$order_voucher->getCreatedByUser()}Záznam přidal dne %1 v %2 administrátor %3{/t}</em><br>
						{/if}
						{!$order_voucher->getInternalNote()|h|nl2br}
					</td>

					<td>
						{dropdown_menu}
							{a action="order_vouchers/edit" id=$order_voucher return_uri=$return_uri}{!"edit"|icon} {t}Upravit{/t}{/a}

							{* Tady zamerne nepouzivame XHR mazani, aby se na strance viditelne zmenily ceny *}
							{capture assign=return_uri}{$request->getRequestUri()}#vouchers{/capture}
							{a_destroy action="order_vouchers/destroy" id=$order_voucher return_uri=$return_uri _xhr=false _confirm="{t}Opravdu chcete smazat tento slevový kupón?{/t}"}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
						{/dropdown_menu}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

{/if}
