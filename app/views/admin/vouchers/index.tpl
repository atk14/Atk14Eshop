<h1>{button_create_new}{/button_create_new} {$page_title}</h1>

{render partial="shared/search_form"}

{if $finder->isEmpty()}

	<p>{t}Nebyl nalezen žádný voucher.{/t}</p>

{else}

	<table class="table">

	<thead>
		<tr>
			<th>#</th>
			<th>{t}Regions{/t}</th>
			{sortable key="voucher_code"}<th>{t}Kód{/t}</th>{/sortable}
			{sortable key="discount"}<th>{t}Hodnota{/t}</th>{/sortable}
			{sortable key="active"}<th>{t}Je aktivní?{/t}</th>{/sortable}
			{sortable key="used"}<th>{t}Byl použit?{/t}</th>{/sortable}
			<th>{t}Platnost od{/t}</th>
			<th>{t}Platnost do{/t}</th>
			{sortable key="created_at"}<th>{t}Datum vytvoření{/t}</th>{/sortable}
			<th>{t}Kupón vytvořil/a{/t}</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		{render partial="voucher_item" from=$finder->getRecords()}
	</tbody>

	</table>

	{paginator}

{/if}
