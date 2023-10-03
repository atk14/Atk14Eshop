<h1>
	{$page_title}

	{render partial="action_buttons"}
</h1>

{render partial="search_form"}

{if $finder->isEmpty()}
	<p>{t}Nebyla nalezena žádná objednávka.{/t}</p>
{else}

<table class="table table-sm table-striped">
	<thead>
		<tr class="table-dark">
			{sortable key=order_no}<th>{t}Číslo obj.{/t}</th>{/sortable}
			{sortable key=created_at}<th>{t}Datum vytvoření{/t}</th>{/sortable}
			<th>{!"user"|icon}</th>
			<th>{t}Zákazník{/t},
			{t}E-mail{/t},
			{t}Telefon{/t}</th>
			<th></th>
			<th>{t}Celk. cena{/t}</th>
			<th>{t}Stav objednávky{/t}</th>
			<th>{t}Pozn.{/t}</th>
			{sortable key=updated_at}<th>{t}Datum posl. změny{/t}</th>{/sortable}
			<th>{t escape=false}Zodp.&nbsp;osoba{/t}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		{render partial=order_item from=$finder->getRecords() item=order}
	</tbody>
</table>

{paginator}

{/if}


