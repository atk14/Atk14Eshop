<li class="search-suggestions-list__item search-suggestions-list__item--{$object_type}{if $class} {$class}{/if}">
	<a href="{$url}" class="suggestion" tabindex="10">

	{if $flags}
		<span class="suggestion__flags">
			{!$flags}
		</span>
	{/if}
	<div class="suggestion__image">
		{if $image_url}
				{assign w $image_url|img_width}
				{assign h $image_url|img_height}
				{if $w/$h>1.2 && $w/$h<1.6}
					{!$image_url|pupiq_img:"80x60xcrop,format=png"}
				{else}
					{!$image_url|pupiq_img:"80x60xtransparent,format=png"}
				{/if}
		{/if}
		{if $icons}
			<span class="suggestion__icons">
				{!$icons}
			</span>
		{/if}
</div>

	{if $type}
	<span class="suggestion__type">
		{$type|lower}
	</span>
	{/if}
	
	<span class="suggestion__description">
		<h3 class="suggestion__title">{highlight_keywords keywords=$params.q opening_tag='<mark>' closing_tag='</mark>'}{!$title}{/highlight_keywords}</h3>

		{if $subtitle}
			<small class="suggestion__subtitle">{highlight_keywords keywords=$params.q opening_tag='<mark>' closing_tag='</mark>'}{!$subtitle}{/highlight_keywords}</small>
		{/if}
	</span>

	{if $price_info}
		<span class="suggestion__price">
			{!$price_info}
		</span>
	{/if}
	</a>
</li>
