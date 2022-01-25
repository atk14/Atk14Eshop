<h1>{button_create_new pricelist_id=$pricelist}{t}Založit novou cenu{/t}{/button_create_new} {$page_title}</h1>

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
			{sortable key="minimum_quantity"}<th>{t}Minimum quantity{/t}</th>{/sortable}
			{sortable key="price"}<th>{t}Price{/t} [{$pricelist->getCurrency()}]</th>{/sortable}
			{sortable key="price_incl_vat"}<th>{t}Price incl. VAT{/t} [{$pricelist->getCurrency()}]</th>{/sortable}
			<th>{t}Valid from{/t}</th>
			<th>{t}Valid to{/t}</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		{foreach $finder->getRecords() as $pricelist_item}

			{assign product $pricelist_item->getProduct()}
			<tr>
				<td>{render partial="shared/list_thumbnail" image=$product->getImage()}</td>
				<td>{highlight_search_query}{$product->getCatalogId()}{/highlight_search_query}</td>
				<td>{highlight_search_query}{$product->getName()}{/highlight_search_query}</td>
				<td>{$pricelist_item->getMinimumQuantity()} {$product->getUnit()}</td>
				<td>{$pricelist_item->getPrice()|display_price:"$currency,format=plain"}</td>
				<td>{$pricelist_item->getPriceInclVat()|display_price:"$currency,format=plain"}</td>
				<td>{$pricelist_item->getValidFrom()|format_datetime|default:$mdash}</td>
				<td>{$pricelist_item->getValidTo()|format_datetime|default:$mdash}</td>
				<td>
					{dropdown_menu}
						{a action="edit" id=$pricelist_item}{!"edit"|icon} {t}Upravit cenu{/t}{/a}
						{a namespace="" action="cards/detail" id=$product->getCardId()}{!"eye"|icon} {t}Zobrazit produkt v e-shopu{/t}{/a}
						{a action="cards/edit" id=$product->getCardId()}{!"edit"|icon} {t}Editovat produkt{/t}{/a}
						{a_destroy id=$pricelist_item}{!"remove"|icon} {t}Smazat cenu{/t}{/a_destroy}
					{/dropdown_menu}
				</td>
			</tr>
		{/foreach}
	</tbody>

</table>

{paginator}

{/if}
