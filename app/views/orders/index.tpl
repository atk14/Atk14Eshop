{capture assign=page_title}{t}Historie a detaily mých objednávek{/t}{/capture}
{render partial="shared/layout/content_header" title=$page_title}

{if $orders}

	<table class="table">
		<thead class="thead--hidden-xs">
			<tr>
				<th>{t}Číslo objednávky{/t}</th>
				<th class="text-sm-right">{t}Cena{/t}</th>
				<th>{t}Datum vytvoření{/t}</th>
				<th>{t}Stav{/t}</th>
				{* <th class="text-sm-right">{t}Faktura{/t}</th> *}
			</tr>
		</thead>
		<tbody>
			{foreach $orders as $o}
			{assign currency $o->getCurrency()}
			<tr>
				<td><span class="table-hint-xs">{t}Číslo objednávky{/t}</span> {a action="orders/detail" id=$o}{$o->getOrderNo()}{/a}</td>
				<td class="text-sm-right"><span class="table-hint-xs">{t}Cena{/t}</span> {!$o->getPriceToPay()|display_price:"$currency,summary"}</td>
				<td><span class="table-hint-xs">{t}Datum vytvoření{/t}</span> {$o->getCreatedAt()|format_date}</td>
				<td><span class="table-hint-xs">{t}Stav{/t}</span> {render partial="shared/order_status" order=$o}</td>
				{* <td class="text-sm-right"><span class="table-hint-xs">{t}Faktura{/t}</span>{a}{t}Faktura{/t} #######{/a}</td> *}
			</tr>
			{/foreach}
		</tbody>
	</table>


{else}

	<p>
		{t}Zatím jste nevytvořili žádnou objednávku{/t}
	</p>

{/if}
