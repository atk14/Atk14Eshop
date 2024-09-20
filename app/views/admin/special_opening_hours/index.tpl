<h1>{button_create_new store_id=$store}{/button_create_new} {$page_title}</h1>

{if $finder->isEmpty()}

	<p>{t}Žádná záznam nebyl nalezen.{/t}</p>

{else}

	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>{t}Datum{/t}</th>
				<th>{t}Otevírací hodiny{/t}</th>
				<th>{t}Poznámka{/t}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{render partial="special_opening_hour_item" from=$finder->getRecords()}
		</tbody>
	</table>

	{paginator}

{/if}


