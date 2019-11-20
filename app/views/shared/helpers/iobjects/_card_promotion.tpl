{assign card $card_promotion->getCard()}
{assign image_url $card_promotion->getImageUrl()}
{assign price_finder PriceFinder::GetInstance()}
{assign starting_price $price_finder->getStartingPrice($card)}

<a href="{$card_promotion->getUrl()}" class="iobject iobject--card_promotion">
	<div class="iobject__image">
		<img class="img-fluid" {!$image_url|img_attrs:800x800xcrop} alt="{$card_promotion->getTitle()}">
		<div class="iobject__flags">
			{if $starting_price && $starting_price->discounted()}
				<div class="product__flag product__flag--sale product__flag--sm">
					<span class="product__flag__title">{t}Discount{/t}</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
				</div>
			{/if}
		</div>
	</div>
	<div class="iobject__body">
		<div>
			<h4 class="iobject__title">
				{$card_promotion->getTitle()}
			</h4>

			<div class="iobject__description">
				{!$card->getTeaser()|markdown}
			</div>
		</div>
		{if $starting_price}
			<span class="iobject__price">
				{!$price_finder->getStartingPrice($card)|display_price:$price_finder->getCurrency()}
				<span class="card-footer-icon">{!"arrow-alt-circle-right"|icon:"regular"}</span>
			</span>
		{/if}
	</div>
</a>
