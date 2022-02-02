{assign incl_vat !$basket->displayPricesWithoutVat()}
{if $price->discounted()}
	<span class="table-products__unit-price-before-sale" {if $unit}data-title="{$unit}"{/if}><s>{!$price->getUnitPriceBeforeDiscount($incl_vat)|display_price:$currency}</s></span>
	<span class="table-products__unit-price-after-sale" {if $unit}data-title="{$unit}"{/if}>{!$price->getUnitPrice($incl_vat)|display_price:$currency}</span>
	<span class="table-products__unit-price-sale">{t}Sleva{/t}&nbsp;{$price->getDiscountPercent()}&nbsp;%</span>
{else}
	{!$price->getUnitPrice($incl_vat)|display_price:$currency}
{/if}
