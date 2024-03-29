<tr>
	<td class="item-id">{highlight_search_query}{$card->getId()}{/highlight_search_query}</td>
	<td class="item-thumbnail">{render partial="shared/list_thumbnail" image=$card->getImage()}</td>
	<td>{highlight_search_query}{render partial="shared/product_codes" products=$card->getProducts(["visible" => null])}{/highlight_search_query}</td>
	<td class="item-title">
		{highlight_search_query}{$card->getName()}{/highlight_search_query}
		{if !$card->isVisible()}
		<br><em>({!"eye-slash"|icon} {t}invisible{/t})</em>
		{/if}
	</td>
	<td class="item-visible">{$card->isVisible()|display_bool}</td>
	<td class="item-hasvariants">{$card->hasVariants()|display_bool}</td>
	<td class="item-tags">{highlight_search_query}{render partial="shared/tags" tags=$card->getTags()}{/highlight_search_query}</td>
	<td class="item-created">{$card->getCreatedAt()|format_datetime}</td>
	<td class="item-updated">{$card->getUpdatedAt()|format_datetime}</td>
	<td class="item-actions">
		{capture assign="confirm"}{t 1=$card->getName()|h escape=no}You are about to delete the product %1.
Are you sure?{/t}{/capture}

		{dropdown_menu}
			{a action=edit id=$card}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
			{a namespace="" action="cards/detail" id=$card}{!"eye"|icon} {t}Show on web{/t}{/a}
			{a action="card_cloning/create_new" card_id=$card}{!"clone"|icon:"regular"} {t}Copy this product{/t}{/a}
			{a action="card_merging/create_new" card_id=$card}{!"plus-square"|icon:"regular"} {t}Merge this product with another{/t}{/a}
			{if $card->isDeletable()}
				{a_destroy id=$card _confirm=$confirm}{!"trash-alt"|icon} {t}Delete product{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}
	</td>
</tr>
