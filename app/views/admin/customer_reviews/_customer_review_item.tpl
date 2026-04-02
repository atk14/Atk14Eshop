{assign product $customer_review->getProduct()}
<tr>
	{highlight_search_query}
	<td>{$customer_review->getId()}</td>
	<td>{$product->getCatalogId()}</td>
	<td>{$product->getName()}</td>
	<td>{$customer_review->getAuthor()|truncate:50|default:$mdash}</td>
	<td>{$customer_review->getTitle()|truncate:50|default:$mdash}</td>
	{/highlight_search_query}
	<td>{$customer_review->getRating()|format_number}</td>
	<td>{render partial="shared/object_status" object_status=$customer_review->getStatus()}</td>
	<td>{$customer_review->getCreatedAt()|format_datetime}</td>
	<td>
		{dropdown_menu}
			{a action="edit" id=$customer_review}{!"edit"|icon} {t}Edit{/t}{/a}
			<a href="{$product|link_to_product}">{!"eye-open"|icon} {t}Show product in eshop{/t}</a>
			{a_destroy id=$customer_review}{!"remove"|icon} {t}Delete{/t}{/a_destroy}
		{/dropdown_menu}
	</td>
</tr>
