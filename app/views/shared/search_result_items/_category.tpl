{*<h4 class="search-result-title">{$category->getName()}</h4>

<p class="item-description">{$category->getTeaser()}</p>

<div class="search-result-links">
	{a action="categories/detail" path=$category->getPath() _class="btn btn-primary btn-md"}{t}Zobrazit kategorii{/t} <i class="icon ion-ios-arrow-forward"></i>{/a}
</div>

{if $category->getImageUrl()}
<div class="search-result-thumbnail">
	{a action="categories/detail" path=$category->getPath()}
		<img {!$category->getImageUrl()|img_attrs:'200x200xcrop'} alt="{$category->getName()}">
	{/a}
</div>
{/if}*}



<li class="search-results-item">
	<div class="search-results-item--image">
		{if $category->getImageUrl()}
			{a action="categories/detail" path=$category->getPath()}
				<img {!$category->getImageUrl()|img_attrs:'575x575xcrop'} alt="{$category->getName()}" class="img-fluid">
			{/a}
		{else}
		{/if}
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				{a action="categories/detail" path=$category->getPath()}{$category->getName()}{/a}<br>
			</h4>
			<p class="search-result-description">{$category->getTeaser()}</p>
		</div>
		<div class="search-results-item--actions">
			{a action="categories/detail" path=$category->getPath() _class="btn btn-primary btn-sm"}{t}Zobrazit kategorii{/t}{/a}
		</div>
	</div>
	<div class="search-results-item--tag">
		{t}Kategorie produktů{/t}
	</div>
</li>