<h1>{button_create_new}{t}Vytvořit novou slevu{/t}{/button_create_new} {$page_title}</h1>

{render partial="shared/form"}

{if !$finder->isEmpty()}

	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th></th>
				{sortable key="discount_percent"}<th>{t}Sleva [%]{/t}</th>{/sortable}
				<th>{t}Nositel{/t}</th>
				{sortable key="created_at"}<th>{t}Datum vytvoření{/t}</th>{/sortable}
				<th></th>
			</tr>
		</thead>
		<tbody>
			{render partial="discount_item" from=$finder->getRecords() item=discount}
		</tbody>
	</table>

	{paginator}

{else}

	<p>{t}Žádná sleva nebyla nalezena.{/t}</p>

{/if}
