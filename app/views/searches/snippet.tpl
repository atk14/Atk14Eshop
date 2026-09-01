{if !$request->xhr()}
<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="noindex,nofollow,noarchive" />
	<meta name="googlebot" content="noindex" />
</head>
<body>
{/if}

<div class="suggestions">
	{if !$finder || $finder->isEmpty()}
		<div class="suggestions__not-found">
		<p><em>{t}Nic nebylo nalezeno.{/t}</em></p>
		</div>
	{else}

		<ul class="search-suggestions-list">
			{foreach $objects as $object}
				{display_search_result_item object=$object suggestion=true}
			{/foreach}
		</ul>

		<div class="suggestions__footer">
			<center>
			{if $finder->hardLimitReached()}
				<p class="justify-content-center">{t}Nalezeno příliš mnoho výsledků. Upřesněte dotaz.{/t}</p>
				<p class="justify-content-center"><a href="{link_to action=index q=$params.q}" class="btn btn-outline-secondary" tabindex="10">{t}Zobrazit výsledky{/t}</a></p>
			{else}
				{if $finder->getTotalAmount()>5}
					<p class="justify-content-center">{t total_amount=$finder->getTotalAmount()}Nalezeno celkem %1 výsledků.{/t}</p>
				{/if}
				{if $finder->getTotalAmount()>$finder->getLimit()}
					<p class="justify-content-center"><a href="{link_to action=index q=$params.q}" class="btn btn-outline-primary" tabindex="10">{t}Zobrazit všechny výsledky{/t}</a></p>
				{/if}
			{/if}
			</center>
		</div>	
	{/if}
</div>

{if !$request->xhr()}
</body>
</html>
{/if}
