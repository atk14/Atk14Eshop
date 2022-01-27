{dropdown_menu clearfix=false}
	{a action="export" warehouse_id=$warehouse}{!"file-csv"|icon} {t}Export{/t}{/a}
	{a action="import" warehouse_id=$warehouse}{!"file-import"|icon} {t}Import from CSV{/t}{/a}
	{a action="warehouses/edit" id=$warehouse}{!"pencil-alt"|icon} {t}Edit warehouse details{/t}{/a}
{/dropdown_menu}

<h1>{button_create_new warehouse_id=$warehouse}{/button_create_new} {$page_title}</h1>

{render partial="shared/search_form"}

{if $finder->isEmpty()}

	<p>{t}No record has been found.{/t}</p>

{else}

<table class="table">

	<thead>
		<tr>
			<th></th>
			{sortable key="catalog_id"}<th>{t}Catalog number{/t}</th>{/sortable}
			{sortable key="stockcount"}<th>{t}Stockcount{/t}</th>{/sortable}
			{sortable key="name"}<th>{t}Product name{/t}</th>{/sortable}
			<th></th>
		</tr>
	</thead>

	<tbody>
		{foreach $finder->getRecords() as $warehouse_item}

			{assign product $warehouse_item->getProduct()}
			<tr>
				<td>{render partial="shared/list_thumbnail" image=$product->getImage()}</td>
				<td>{highlight_search_query}{$product->getCatalogId()}{/highlight_search_query}</td>
				<td>{$warehouse_item->getStockcount()} {$product->getUnit()}</td>
				<td>{highlight_search_query}{$product->getName()}{/highlight_search_query}</td>
				<td>
					{dropdown_menu}
						{a action="edit" id=$warehouse_item}{t}Edit{/t}{/a}
						{a namespace="" action="cards/detail" id=$product->getCardId()}{t}Show product in eshop{/t}{/a}
						{a action="cards/edit" id=$product->getCardId()}{t}Edit product{/t}{/a}
						{a_destroy id=$warehouse_item}{t}Delete entry{/t}{/a_destroy}
					{/dropdown_menu}
				</td>
			</tr>
		{/foreach}
	</tbody>

</table>

{paginator}

{/if}
