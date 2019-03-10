{if $price->discounted()}
	<span class="table-products__unit-price-before-sale" {if $unit}data-title="{$unit}"{/if}><s>{!$price->getUnitPriceBeforeDiscountInclVat()|display_price:$currency}</s></span>
	<span class="table-products__unit-price-after-sale" {if $unit}data-title="{$unit}"{/if}>{!$price->getUnitPriceInclVat()|display_price:$currency}</span>
	<span class="table-products__unit-price-sale">{t}Sleva{/t}&nbsp;{$price->getDiscountPercent()}&nbsp;%</span>
{else}
	{!$price->getUnitPriceInclVat()|display_price:$currency}
{/if}
