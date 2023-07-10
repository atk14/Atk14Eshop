{*
 *	{render partial="shared/card_price" card=$card}
 *
 *	{render partial="shared/card_price" card=$card default_price_label=""}
 *	{render partial="shared/card_price" card=$card default_price_label="Your price" class="card-price--sm"}
 *}
{assign starting_price $price_finder->getStartingPrice($card)}
{assign distinct_prices $price_finder->getDistinctPrices($card)}
{assign products $card->getProducts()}
{assign product_type $card->getProductType()}
{if !$basket}{assign basket Basket::GetDummyBasket()}{/if}
{assign incl_vat $basket->displayPricesInclVat()}
{assign currency $price_finder->getCurrency()}

{capture assign=dp_options}{$currency}{if !$incl_vat},without_vat,show_vat_label{/if}{/capture}
{capture assign=dp_incl_vat_options}{$currency},show_vat_label{/capture}

{if !isset($default_price_label) && $product_type->getCode()!="product"}
	{assign default_price_label $product_type}
{/if}

<div class="card-price{if $class} {$class}{/if}">
{if $starting_price}
	{if sizeof($distinct_prices)>=2 && sizeof($distinct_prices)<=3 && sizeof($products)<=3}
		<ul class="list-unstyled">
			{foreach $products as $product}
				{assign price $price_finder->getPrice($product)}
				<li>
					<small>{$product->getLabel()}</small>
					{if $price->getOriginalProductPrice()}
						<span class="price--before-discount">{!$price->getOriginalProductPrice()|display_price:$dp_options}</span>
					{/if}
					<div class="price--primary">{!$price|display_price:$dp_options}</div>
					{if !$incl_vat}
						<div class="price--incl-vat">{!$price|display_price:$dp_incl_vat_options}</div>
					{/if}
				</li>
			{/foreach}
		</ul>

	{elseif $distinct_prices && sizeof($distinct_prices)==2}
		{* there are two price on the card *}

		<ul class="list-unstyled">
			{foreach $distinct_prices as $price}
				<li>
					<div class="price--primary">{!$price|display_price:$dp_options}</div>
					{if !$incl_vat}
						<div class="price--incl-vat">{!$price|display_price:$dp_incl_vat_options}</div>
					{/if}
				</li>
			{/foreach}
		</ul>

	{elseif $distinct_prices && sizeof($distinct_prices)>2}
		{* there are more than two price on the card *}

		{t price=$starting_price|display_price:$dp_options escape=no}<small>cena od</small><div class="price--primary">%1</div>{/t}
		{if !$incl_vat}
			<div class="price--incl-vat">{!$starting_price|display_price:$dp_incl_vat_options}</div>
		{/if}

	{else}
		{* there is just one price on the card *}

		{if $default_price_label}
			<small>{$default_price_label}</small><br>
		{/if}
		{if $starting_price && $starting_price->getOriginalProductPrice()}
			<span class="price--before-discount">{!$starting_price->getOriginalProductPrice()|display_price:$dp_options}</span>
		{/if}

		<div class="price--primary">{!$starting_price|display_price:$dp_options}</div>
		{if !$incl_vat}
			<div class="price--incl-vat">{!$starting_price|display_price:$dp_incl_vat_options}</div>
		{/if}

	{/if}
{else}
	<small><em>{t}není v nabídce{/t}</em></small>
{/if}
</div>
