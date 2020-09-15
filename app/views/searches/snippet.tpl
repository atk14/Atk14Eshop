<div class="suggestions">
	{if $finder->isEmpty()}
		<div class="suggestions__not-found">
		<p><em>{t}Nic nebylo nelezeno.{/t}</em></p>
		</div>
	{else}

		<ul class="search-suggestions-list">
			{foreach $finder->getItems() as $item}
				{display_search_result_item item=$item suggestion=true}
			{/foreach}
		</ul>

		<div class="suggestions__footer">
		{if $finder->getTotalAmount()>5}
			<p>{t total_amount=$finder->getTotalAmount()}Nalezeno celkem %1 výsledků.{/t}</p>
		{/if}
		<a href="{link_to action=index q=$params.q}" class="btn btn-secondary">{t}Zobrazit výsledky{/t}</a>
		</div>	
	{/if}
</div>