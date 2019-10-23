{assign starting_price $price_finder->getStartingPrice($card)}

{a action="cards/detail" id=$card _class="card"}{trim}
	{if $card->getImage()}
		{!$card->getImage()|pupiq_img:"400x300xcrop":"class='card-img-top'"}
	{else}
		<img src="{$public}images/camera.svg" width="400" height="300" title="{t}no image{/t}">
	{/if}

	<div class="flags">		
		{if $starting_price && $starting_price->discounted()}
			<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">{t}Discount{/t}</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
			</div>
		{/if}
	</div>

	{if $card->getTags()}
		<div class="card__tags">
			{foreach $card->getTags() as $tag}
				{if !$tag@first} {/if}
				<span class="badge badge-dark tag-item {if $tag=="news" || $tag=="action"}tag--{$tag}{/if}">{!"tag"|icon} {$tag->getTagLocalized()}</span>
			{/foreach}
		</div>
	{/if}

	<div class="card-body">
		<h4 class="card-title">{$card->getName()}</h4>
		<div class="card-text">{!$card->getTeaser()|markdown}</div>
	</div>

	<div class="card-footer">
		{if $starting_price}
			<span class="card-price">{!$price_finder->getStartingPrice($card)|display_price:$price_finder->getCurrency()}</span>
			<span class="card-footer-icon">{!"arrow-alt-circle-right"|icon:"regular"}</span>
		{/if}
	</div>

{/trim}{/a}
