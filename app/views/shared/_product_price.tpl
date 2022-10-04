{trim}

{assign price $price_finder->getPrice($product)}
{if !$price}
	{!$fallback_message} {* must be HTML safe *}
{else}
	{assign incl_vat $basket->displayPricesInclVat()}
	{assign currency $price_finder->getCurrency()}
	{capture assign=dp_options}{$currency}{if !$incl_vat},without_vat,show_vat_label{/if}{/capture}
	
	{!$price|display_price:$dp_options}
	{if !$incl_vat}
		<div class="price--incl-vat">{!$price|display_price:"$currency,show_vat_label"}</div>
	{/if}
{/if}

{/trim}
