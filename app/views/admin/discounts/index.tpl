<h1>{button_create_new}{t}Vytvořit novou slevu{/t}{/button_create_new} {$page_title}</h1>

{render partial="shared/search_form"}

{if !$finder->isEmpty()}

	<table class="table table-sm">
		<thead>
			<tr class="table-dark">
				<th>#</th>
				<th></th>
				{sortable key="discount_percent"}<th>{t}Sleva [%]{/t}</th>{/sortable}
				<th>{t}Nositel{/t}</th>
				<th>{t}Valid from{/t}</th>
				<th>{t}Valid to{/t}</th>
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

	<p>{t}The list is empty.{/t}</p>

{/if}
