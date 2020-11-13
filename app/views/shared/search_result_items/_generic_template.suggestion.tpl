<li>
	<a href="{$url}" class="suggestion" tabindex="10">
	{if $image_url}
		<div class="suggestion__image">
			{assign w $image_url|img_width}
			{assign h $image_url|img_height}
			{if $w/$h>1.2 && $w/$h<1.6}
				{!$image_url|pupiq_img:"80x60xcrop,format=png"}
			{else}
				{!$image_url|pupiq_img:"80x60xtransparent,format=png"}
			{/if}
		</div>
	{/if}

	{if $type}
	<span class="suggestion__type">
		<small>{$type|lower}</small>
	</span>
	{/if}
	
	<span class="suggestion__description">
		<h3 class="suggestion__title">{$title}</h3>

		{if $subtitle}
			<small class="suggestion__subtitle">{$subtitle}</small>
		{/if}
	</span>

	{if $price_info}
		<span class="suggestion__price">
			{!$price_info}
		</span>
	{/if}
	</a>
</li>
