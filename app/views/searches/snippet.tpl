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
			<center>
			{if $finder->getTotalAmount()>5}
				<p class="justify-content-center">{t total_amount=$finder->getTotalAmount()}Nalezeno celkem %1 výsledků.{/t}</p>
			{/if}
			{if $finder->getTotalAmount()>$finder->getLimit()}
				<p class="justify-content-center"><a href="{link_to action=index q=$params.q}" class="btn btn-outline-primary">{t}Zobrazit všechny výsledky{/t}</a></p>
			{/if}
			</center>
		</div>	
	{/if}
</div>
