{if $finder->isEmpty()}

	<p><em>{t}Nic nebylo nelezeno.{/t}</em></p>

{else}

<ul class="search-results-list">
	{foreach $finder->getItems() as $item}
		{display_search_result_item item=$item suggestion=true}
	{/foreach}
</ul>

{/if}
