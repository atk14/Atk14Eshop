{*
	{assign starting_price $price_finder->getStartingPrice($card)}
	{render partial="shared/card_price" starting_price=$starting_price}
*}
<span class="card-price">
	{if $starting_price->discounted()}
		<span class="card-price--before-discount">{!$starting_price->getUnitPriceBeforeDiscountInclVat()|display_price:$price_finder->getCurrency()}</span>
	{/if}
	{!$starting_price|display_price:$price_finder->getCurrency()}
</span>