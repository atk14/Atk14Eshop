{assign starting_price $price_finder->getStartingPrice($card)}
{assign creators CardCreator::GetMainCreatorsForCard($card)}

{a action="cards/detail" id=$card _class="card"}{trim}
	{if $card->getImage()}
		<img {!$card->getImage()|img_attrs:"400x300x#ffffff"} class="card-img-top" alt="{$card->getName()}">
	{else}
		<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top">
	{/if}

	<div class="card__flags">
		{if $starting_price && $starting_price->discounted()}
			<div class="product__flag product__flag--sale product__flag--lg">
				<span class="product__flag__title">{t}Discount{/t}</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
			</div>
		{/if}
	</div>

	{if $card->getTags()}
		<div class="card__tags">
			{render partial="shared/tags" tags=$card->getTags()}
		</div>
	{/if}

	<div class="card-body">
		<h4 class="card-title">{$card->getName()}</h4>
		{if $creators}
			{foreach $creators as $creator}
				<div class="card-author">{$creator}</div>
			{/foreach}
		{/if}
		<div class="card-text">{!$card->getTeaser()|markdown}</div>
	</div>

	<div class="card-footer">
		{if $starting_price}
			{render partial="shared/card_price" card=$card}
			<span class="card-footer-icon">{!"chevron-right"|icon}</span>
		{/if}
	</div>

{/trim}{/a}
