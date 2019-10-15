{assign starting_price $price_finder->getStartingPrice($card)}

{a action="cards/detail" id=$card _class="card"}{trim}
	{if $card->getImage()}
		{!$card->getImage()|pupiq_img:"400x300xcrop":"class='card-img-top'"}
	{else}
		<img src="{$public}images/camera.svg" width="400" height="300" title="{t}no image{/t}">
	{/if}

	{if $card->getTags()}
		<div class="tags">
			{foreach $card->getTags() as $tag}
				{if !$tag@first} {/if}
				<span class="badge badge-dark tag-item">{!"tag"|icon} {$tag->getTagLocalized()}</span>
			{/foreach}
		</div>
	{/if}

	<div class="card-body">
		<h4 class="card-title">{$card->getName()}</h4>
		<div class="card-text">{$card->getTeaser()}</div>
	</div>

	<div class="card-footer">
		{if $starting_price}
			<span class="card-price">{!$price_finder->getStartingPrice($card)|display_price:$price_finder->getCurrency()}</span>
			<span class="card-footer-icon">{!"arrow-alt-circle-right"|icon:"regular"}</span>
		{/if}
	</div>

{/trim}{/a}
