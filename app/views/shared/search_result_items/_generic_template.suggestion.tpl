<li>
	<a href="{$url}" class="suggestion" tabindex="10">
	{if $image_url}
		<div class="suggestion__image">
			{!$image_url|pupiq_img:"80x60xtransparent,format=png"}
		</div>
	{/if}

	{if $type}
	<span class="suggestion__type">
		<span class="">{$type|lower}</span>
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
