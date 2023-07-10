{assign starting_price $price_finder->getStartingPrice($card)}
{assign creators CardCreator::GetMainCreatorsForCard($card)}
<div class="card card--hoverable card--id-{$card->getId()}{if $basket->contains($card)} card--in-basket{/if}">{trim}
	<a class="card__image" href="{link_to action="cards/detail" id=$card}">
		{if $card->getImage()}
			<img {!$card->getImage()|img_attrs:"400x300x#ffffff"} class="card-img-top" alt="{$card->getName()}">
		{else}
			<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="{t}no image{/t}" class="card-img-top default-image">
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
		{render partial="shared/card_icons"}
	</a>
	<div class="card-body">
		<a class="card-title h4" href="{link_to action="cards/detail" id=$card}">{$card->getName()}</a>
		{if $creators}
			{foreach $creators as $creator}
				<div class="card-author">{$creator}</div>
			{/foreach}
		{/if}
		<div class="card-text">{$card->getTeaser()|markdown|strip_html|truncate:300}</div>
	</div>

	<div class="card-footer">
		{if $starting_price}
			{render partial="shared/card_price" card=$card class="card-price--sm"}
			{if $card->canBeOrdered()}
				{a_remote action="baskets/add_card" card_id=$card _method=post _class="btn btn-outline-primary btn-xsm"}{!"shopping-cart"|icon} {t}Add to basket{/t}{/a_remote}
			{/if}
		{/if}
	</div>

{/trim}</div>