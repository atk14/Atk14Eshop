<li class="search-results-item">
	<div class="search-results-item--image">
		{if $article->getImageUrl()}
			{a action="articles/detail" id=$article}
				<img {!$article->getImageUrl()|img_attrs:'600x450'} alt="{$article->getTitle()}" class="img-fluid">
			{/a}
		{else}
		{/if}
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				{a action="articles/detail" id=$article}{$article->getTitle()}{/a}<br>
			</h4>
			<small>{t date=$article->getPublishedAt()|format_date escape=no}Zveřejněno dne %1{/t}</small>
			<p class="search-result-description">{$article->getTeaser()}</p>
		</div>
		<div class="search-results-item--actions">
			{a action="articles/detail" id=$article _class="btn btn-primary btn-sm"}{t}Celý článek{/t}{/a}
		</div>
	</div>
	<div class="search-results-item--tag">
		{t}Článek{/t}
	</div>
</li>