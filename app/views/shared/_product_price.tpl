{trim}

{assign price $price_finder->getPrice($product)}
{if !$price}
	{!$fallback_message} {* must be HTML safe *}
{else}
	{assign incl_vat $basket->displayPricesInclVat()}
	{assign currency $price_finder->getCurrency()}
	{capture assign=dp_options}{$currency}{if !$incl_vat},without_vat{/if}{/capture}
	{capture assign=excl_vat}{if !$incl_vat} {t}excl. VAT{/t}{/if}{/capture}
	
	{!$price|display_price:$dp_options}{$excl_vat}
	{if !$incl_vat}
		<div class="price--incl-vat">{!$price|display_price:"$currency"} {t}incl. VAT{/t}</div>
	{/if}
{/if}

{/trim}
