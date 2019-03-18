<h1>{t}Historie a detaily mých objednávek{/t}</h1>

{if $orders}

	<table class="table-products table-products--main">
		<thead class="sr-only">
			<tr>
				<th>{t}Číslo objednávky{/t}</th>
				<th>{t}Datum{/t}</th>
				<th class="text-right">{t}Cena{/t}</th>
				{* <th class="text-right">{t}Faktura{/t}</th> *}
			</tr>
		</thead>
		<tbody>
			{foreach $orders as $o}
			{assign currency $o->getCurrency()}
			<tr>
				<td>{a action="orders/detail" id=$o}{$o->getOrderNo()}{/a}</li></td>
				<td>{$o->getCreatedAt()|format_date}</td>
				<td>{!$o->getPriceToPay()|display_price:"$currency,summary"}</td>
				{* <td>{a}{t}Faktura{/t} #######{/a}</td> *}
			</tr>
			{/foreach}
		</tbody>
	</table>


{else}

	<p>
		{t}Zatím jste nevytvořili žádnou objednávku{/t}
	</p>

{/if}
