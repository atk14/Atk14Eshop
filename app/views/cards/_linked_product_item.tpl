{assign starting_price $price_finder->getStartingPrice($c)}
{assign creators CardCreator::GetMainCreatorsForCard($c)}
{a action="cards/detail" id=$c _class="card"}
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
			{render partial="shared/card_price" starting_price=$starting_price}
		{/if}
		<span class="card-footer-icon">{!"chevron-right"|icon}</span>
	</div>
{/a}