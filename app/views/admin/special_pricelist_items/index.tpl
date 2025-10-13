<h1>{button_create_new special_pricelist_id=$special_pricelist}{t}Založit novou cenu{/t}{/button_create_new} {$page_title}</h1>

{render partial="shared/search_form"}

{if $finder->isEmpty()}

	<p>{t}No record has been found.{/t}</p>

{else}

<table class="table">

	<thead>
		<tr>
			<th></th>
			{sortable key="catalog_id"}<th>{t}Catalog number{/t}</th>{/sortable}
			{sortable key="name"}<th>{t}Product name{/t}</th>{/sortable}
			{sortable key="price"}<th>{t}Price{/t} [{$special_pricelist->getCurrency()}]</th>{/sortable}
			{sortable key="price_incl_vat"}<th>{t}Price incl. VAT{/t} [{$special_pricelist->getCurrency()}]</th>{/sortable}
			{sortable key="discount_percent"}<th>{t}Sleva [%]{/t}</th>{/sortable}
			<th></th>
		</tr>
	</thead>

	<tbody>
		{foreach $finder->getRecords() as $special_pricelist_item}

			{assign product $special_pricelist_item->getProduct()}
			<tr>
				<td>{render partial="shared/list_thumbnail" image=$product->getImage()}</td>
				<td>{highlight_search_query}{$product->getCatalogId()}{/highlight_search_query}</td>
				<td>{highlight_search_query}{$product->getName()}{/highlight_search_query}</td>
				<td>{$special_pricelist_item->getPrice()|display_price:"$currency,format=plain"|default:$mdash}</td>
				<td>{$special_pricelist_item->getPriceInclVat()|display_price:"$currency,format=plain"|default:$mdash}</td>
				<td>{$special_pricelist_item->getDiscountPercent()|display_number|default:$mdash}</td>
				<td>
					{dropdown_menu}
						{a action="edit" id=$special_pricelist_item}{!"edit"|icon} {t}Upravit cenu{/t}{/a}
						{a namespace="" action="cards/detail" id=$product->getCardId()}{!"eye"|icon} {t}Zobrazit produkt v e-shopu{/t}{/a}
						{a action="cards/edit" id=$product->getCardId()}{!"edit"|icon} {t}Editovat produkt{/t}{/a}
						{a_destroy id=$special_pricelist_item}{!"remove"|icon} {t}Smazat cenu{/t}{/a_destroy}
					{/dropdown_menu}
				</td>
			</tr>
		{/foreach}
	</tbody>

</table>

{paginator}

{/if}
