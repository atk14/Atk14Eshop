{assign card $card_promotion->getCard()}
{assign image_url $card_promotion->getImageUrl()}
{assign price_finder PriceFinder::GetInstance()}
{assign starting_price $price_finder->getStartingPrice($card)}

<a href="{$card_promotion->getUrl()}" class="iobject iobject--card_promotion">
	<div class="iobject__image">
		<img class="img-fluid" {!$image_url|img_attrs:800} alt="{$card_promotion->getTitle()}">
	</div>
	<div class="iobject__body">
		<h4 class="iobject__title">
			{$card_promotion->getTitle()}
		</h4>

		<div class="iobject__description">
			{$card->getTeaser()}
		</div>
		{if $starting_price}
			<span class="iobject__price">
				{!$price_finder->getStartingPrice($card)|display_price}
				<span class="card-footer-icon">{!"arrow-alt-circle-right"|icon:"regular"}</span>
			</span>
		{/if}
	</div>
</a>
