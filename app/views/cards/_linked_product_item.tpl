{assign starting_price $price_finder->getStartingPrice($c)}
{assign creators CardCreator::GetMainCreatorsForCard($c)}
{if $basket->contains($c)}
	{assign var="card_class" "card card--sm card--in-basket card--id-{$c->getId()}"}
{else}
	{assign var="card_class" "card card--sm"}
{/if}
{a action="cards/detail" id=$c _class="$card_class"}
	<div class="card__image">
		{if $c->getImage()}
			{!$c->getImage()|pupiq_img:"300x225xcrop":"class='card-img-top'"}
		{else}
			<img src="{$public}images/camera.svg" width="300" height="225" title="{t}no image{/t}">
		{/if}
		<div class="card__flags">
			{if $starting_price && $starting_price->discounted()}
				<div class="product__flag product__flag--sale product__flag--sm">
					<span class="product__flag__title">{t}Discount{/t}</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
				</div>
			{/if}
		</div>
		{render partial="shared/card_icons" card=$c}
	</div>
	<div class="card-body">
		<h4 class="card-title">{$c->getName()}</h4>
		{if $creators}
		<div class="card-author">
			{foreach $creators as $creator}{trim}
				{if $creator@iteration > 1}, {/if}{$creator}
			{/trim}{/foreach}
		</div>
		{/if}
	</div>
	<div class="card-footer">
		{if $starting_price}
			{render partial="shared/card_price" card=$c}
		{/if}
		<span class="card-footer-icon">{!"chevron-right"|icon}</span>
	</div>
{/a}
