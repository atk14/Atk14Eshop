{assign starting_price $price_finder->getStartingPrice($c)}
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
	{$c->getName()}
	</div>
	<div class="card-footer">
		{if $starting_price}
			<span class="card-price">{!$price_finder->getStartingPrice($card)|display_price:$price_finder->getCurrency()}</span>
			<span class="card-footer-icon">{!"arrow-alt-circle-right"|icon:"regular"}</span>
		{/if}
	</div>
{/a}