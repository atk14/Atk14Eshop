<h1>{button_create_new}{/button_create_new} {$page_title}</h1>

<p>{t}Administrace slevových kupónů ve formě dárkového nebo slevového poukazu. Sleva na základě kódu se uplatní na jakýkoliv produkt v e-shopu. Nelze prioritizovat žádnou kategorii.{/t}</p>

{render partial="shared/search_form"}

{if $finder->isEmpty()}

	<p>{t}Nebyl nalezen žádný voucher.{/t}</p>

{else}

	<table class="table table-sm">

	<thead>
		<tr class="table-dark">
			<th>#</th>
			<th>{t}Regions{/t}</th>
			<th></th>
			{sortable key="voucher_code"}<th>{t}Kód{/t}</th>{/sortable}
			{sortable key="discount"}<th>{t}Hodnota{/t}</th>{/sortable}
			{sortable key="active"}<th>{t}Je aktivní?{/t}</th>{/sortable}
			{sortable key="used"}<th>{t}Byl použit?{/t}</th>{/sortable}
			<th>{t}Valid from{/t}</th>
			<th>{t}Valid to{/t}</th>
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
