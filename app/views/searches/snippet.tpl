{if $finder->isEmpty()}

	<p><em>{t}Nic nebylo nelezeno.{/t}</em></p>

{else}

	<ul class="search-suggestions-list">
		{foreach $finder->getItems() as $item}
			{display_search_result_item item=$item suggestion=true}
		{/foreach}
	</ul>

	{if $finder->getTotalAmount()>5}
		<p>{t total_amount=$finder->getTotalAmount()}Nalezeno celkem %1 výsledků.{/t}</p>
	{/if}

	<a href="{link_to action=index q=$params.q}" class="btn btn-secondary">{t}Zobrazit výsledky{/t}</a>

{/if}
