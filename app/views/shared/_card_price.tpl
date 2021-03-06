{*
 *	{render partial="shared/card_price" card=$card}
 *
 *	{render partial="shared/card_price" card=$card default_price_label=""}
 *	{render partial="shared/card_price" card=$card default_price_label="Your price"}
 *}
{assign starting_price $price_finder->getStartingPrice($card)}
{assign distinct_prices $price_finder->getDistinctPrices($card)}
{assign products $card->getProducts()}
{assign product_type $card->getProductType()}

{if !isset($default_price_label) && $product_type->getCode()!="product"}
	{assign default_price_label $product_type}
{/if}

<div class="card-price">
{if $starting_price}
	{if sizeof($distinct_prices)>=2 && sizeof($distinct_prices)<=3 && sizeof($products)<=3}
		<ul class="list-unstyled">
			{foreach $products as $product}
				{assign price $price_finder->getPrice($product)}
				<li><small>{$product->getLabel()}</small><br>{!$price|display_price:$price_finder->getCurrency()}</li>
			{/foreach}
		</ul>

	{elseif $distinct_prices && sizeof($distinct_prices)==2}
		{* there are two price on the card *}

		<ul class="list-unstyled">
			<li>{!$distinct_prices.0|display_price:$price_finder->getCurrency()}</li>
			<li>{!$distinct_prices.1|display_price:$price_finder->getCurrency()}</li>
		</ul>

	{elseif $distinct_prices && sizeof($distinct_prices)>2}
		{* there are more than two price on the card *}

		{t price=$starting_price|display_price:$price_finder->getCurrency() escape=no}<small>cena od</small><br>%1{/t}

	{else}
		{* there is just one price on the card *}

		{if $default_price_label}
			<small>{$default_price_label}</small><br>
		{/if}
		{if $starting_price->discounted()}
			<span class="card-price--before-discount">{!$starting_price->getUnitPriceBeforeDiscountInclVat()|display_price:$price_finder->getCurrency()}</span>
		{/if}
		{!$starting_price|display_price:$price_finder->getCurrency()}

	{/if}
{else}
	<small><em>{t}není v nabídce{/t}</em></small>
{/if}
</div>
