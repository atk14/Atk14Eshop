<tr>
	{highlight_search_query}
	<td class="item-id">{$article->getId()}</td>
	<td class="item-thumbnail">{render partial="shared/list_thumbnail" image=$article->getImageUrl()}</td>
	<td class="item-title">{$article->getTitle()}</td>
	<td class="item-author">{$article->getAuthor()->getLogin()}</td>
	{/highlight_search_query}
	<td class="item-published"><time datetime="{$article->getPublishedAt()}">{$article->getPublishedAt()|format_date}</time></td>
	<td class="item-tags">{render partial="shared/tags" tags=$article->getTags()}</td>
	<td class="item-actions text-right">
		{capture assign=confirm}{t title=$article->getTitle()|h escape=false}Are you sure to delete article item
%1?{/t}{/capture}

		{dropdown_menu}
			{a action=edit id=$article}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
			{a action=detail id=$article namespace=""}{!"eye-open"|icon} {t}Visit public link{/t}{/a}
			{a_destroy id=$article _confirm=$confirm}{!"trash-alt"|icon} {t}Delete article{/t}{/a_destroy}
		{/dropdown_menu}
	</td>
</tr>
