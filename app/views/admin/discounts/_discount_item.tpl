{assign category $discount->getCategory()}
{assign product $discount->getProduct()}

<tr>
	<td>{$discount->getId()}</td>
	<td>
		{if $category}
			{render partial="shared/list_thumbnail" image=$category->getImage()}
		{/if}
		{if $product}
			{render partial="shared/list_thumbnail" image=$product->getImage()}
		{/if}
	</td>
	<td>{$discount->getDiscountPercent()}</td>
	<td>
		{if $category}
			{t id=$category->getId()}kategorie #%1{/t}<br>
			{a action="categories/edit" id=$category}/{$category->getPath()}/{/a}
		{else}
			{t id=$product->getCatalogId()}produkt %1{/t}<br>
			{a action="cards/edit" id=$product->getCardId()}{$product->getName()}{/a}
		{/if}
	</td>
	<td>{$discount->getCreatedAt()|format_datetime}</td>
	<td>
		{dropdown_menu pull_right=1}
			{a action="edit" id=$discount}{t}Editovat{/t}{/a}
			{a_destroy id=$discount}{t}Smazat{/t}{/a_destroy}
		{/dropdown_menu}
	</td>
</tr>
