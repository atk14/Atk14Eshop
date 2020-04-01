{*
 *	{render partial="shared/card_price" card=$card}
 *}
{assign starting_price $price_finder->getStartingPrice($card)}
{assign distinct_prices $price_finder->getDistinctPrices($card)}

{if $starting_price}
<span class="card-price">
	{if $distinct_prices && sizeof($distinct_prices)==2}
		{* there are two price on the card *}

		<ul class="list-unstyled">
			<li>{!$distinct_prices.0|display_price:$price_finder->getCurrency()}</li>
			<li>{!$distinct_prices.1|display_price:$price_finder->getCurrency()}</li>
		</ul>

	{elseif $distinct_prices && sizeof($distinct_prices)>2}
		{* there are more than two price on the card *}

		{t price=$starting_price|display_price:$price_finder->getCurrency() escape=no}cena od %1{/t}

	{else}
		{* there is just one price on the card *}

		{if $starting_price->discounted()}
			<span class="card-price--before-discount">{!$starting_price->getUnitPriceBeforeDiscountInclVat()|display_price:$price_finder->getCurrency()}</span>
		{/if}
		{!$starting_price|display_price:$price_finder->getCurrency()}

	{/if}
</span>
{/if}
