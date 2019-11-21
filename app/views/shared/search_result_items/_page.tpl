{assign root_page $page->getRootPage()}
<li class="search-results-item">
	<div class="search-results-item--image">
		{if $page->getImageUrl()}
			{a action="pages/detail" id=$page}
				<img {!$page->getImageUrl()|img_attrs:'575x575xcrop'} alt="{$page->getTitle()}" class="img-fluid">
			{/a}
		{elseif $root_page->getImageUrl()}
			{a action="pages/detail" id=$page}
				<img {!$root_page->getImageUrl()|img_attrs:'575x575xcrop'} alt="{$page->getTitle()}" class="img-fluid">
			{/a}
		{else}
		{/if}
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				{if $root_page->getId()!=$page->getId()}
					{a action="pages/detail" id=$root_page}{$root_page->getTitle()}{/a} /
				{/if}
				{a action="pages/detail" id=$page}{$page->getTitle()}{/a}
			</h4>
			<p class="search-result-description">{$page->getTeaser()|markdown|strip_tags:false}</p>
		</div>
		<div class="search-results-item--actions">
			{a action="pages/detail" id=$page _class="btn btn-primary btn-sm"}{t}Zobrazit stránku{/t}{/a}
		</div>
	</div>
	<div class="search-results-item--tag">
		{t}Stránka{/t}
	</div>
</li>
