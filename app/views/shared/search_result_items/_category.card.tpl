<div class="card card--search card--search--category">
	{a action="categories/detail" path=$category->getPath()}
		{if $category->getImageUrl()}
			<img {!$category->getImageUrl()|img_attrs:'400x300x#ffffff'} alt="{$category->getName()}" class="card-img-top">
		{else}
			<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top">
		{/if}
	{/a}
	
	<div class="card__label">
		{t}Kategorie{/t}
	</div>
	
	<div class="card-body">
		<h4 class="card-title">{a action="categories/detail" path=$category->getPath()}{$category->getLongName()}{/a}</h4>
		<div class="card-text">{$category->getTeaser()}</div>
	</div>

	<div class="card-footer">
		{a action="categories/detail" path=$category->getPath() _class="btn btn-primary btn-sm"}{t}Zobrazit kategorii{/t}{/a}
	</div>
</div>
