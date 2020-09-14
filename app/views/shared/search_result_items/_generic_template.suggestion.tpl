<li>
	{if $image_url}
		<a href="{$url}">
			{!$image_url|pupiq_img:"80x60x#ffffff"}
		</a>
	{/if}

	{if $type}
		<span class="badge badge-secondary">{$type}</span>
	{/if}

	<a href="{$url}">{$title}</a>

	{if $subtitle}
		<small>{$subtitle}</small>
	{/if}

	{if $price_info}
		{!$price_info}
	{/if}
</li>
