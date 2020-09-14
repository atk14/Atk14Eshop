<li class="suggestion">
	{if $image_url}
		<a href="{$url}" class="suggestion__image">
			{!$image_url|pupiq_img:"80x60x#ffffff"}
		</a>
	{/if}

	{if $type}
	<span class="suggestion__type">
		<span class="badge badge-secondary">{$type}</span>
	</span>
	{/if}
	
	<span class="suggestion__title">
		<a href="{$url}">{$title}</a>

		{if $subtitle}
			<small class="suggestion__subtitle">{$subtitle}</small>
		{/if}
	</span>

	{if $price_info}
		<span class="suggestion__price">
			{!$price_info}
		</span>
	{/if}
</li>
