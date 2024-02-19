<tr>
	<td>{highlight_search_query}{$campaign->getId()}{/highlight_search_query}</td>

	<td>{render partial="shared/region_list" regions=$campaign->getRegions()}</td>

	<td>{highlight_search_query}{$campaign->getName()}{/highlight_search_query}</td>

	{* Podminky *}
	<td>
		{highlight_search_query}
		<ul>
			{if $campaign->getMinimalItemsPriceInclVat()}
				{assign currency Currency::GetDefaultCurrency()}
				<li>{t price=$campaign->getMinimalItemsPriceInclVat()|display_price:"$currency,format=plain"}minimální výše objednávky %1{/t}</li>
			{else}
				<li>{t}bez omezení výše objednávky{/t}</li>
			{/if}
			{if $campaign->getRequiredCustomerGroup()}
				<li>{t customer_group=$campaign->getRequiredCustomerGroup()}pouze pro zákaznickou skupinu %1{/t}</li>
			{/if}
			{if $campaign->getRequiredDeliveryMethod()}
				<li>{t delivery_method=$campaign->getRequiredDeliveryMethod()}pouze při zvoleném způsobu doručení %1{/t}</li>
			{/if}
			{if $campaign->getRequiredPaymentMethod()}
				<li>{t payment_method=$campaign->getRequiredPaymentMethod()}pouze při zvolené platební metodě %1{/t}</li>
			{/if}
			{if $campaign->getDesignatedForTags()}
				<li>{t}Určeno pro štítky{/t}: {$campaign->getDesignatedForTags()|to_sentence}</li>
			{/if}
			{if $campaign->getExcludedForTags()}
				<li>{t}Vyloučeno pro štítky{/t}: {$campaign->getExcludedForTags()|to_sentence}</li>
			{/if}
		</ul>
		{/highlight_search_query}
	</td>

	{* Obsah *}
	<td>
		<ul>
		{if $campaign->freeShipping()}
			<li>
				{t}doprava zdarma{/t}
				{if $campaign->getDeliveryMethod()}
					({t dm=$campaign->getDeliveryMethod()}pouze pro způsob doručení %1{/t})
				{/if}
			</li>
		{/if}
		{if $campaign->getDiscountPercent()}
			<li>{t discount_percent=$campaign->getDiscountPercent()}sleva %1%{/t}</li>
		{/if}
		{if $campaign->getGiftProduct()}
			<li>{t escape=no amount=$campaign->getGiftAmount() product=$campaign->getGiftProduct()|h}dárek k objednávce: %1 &times; %2{/t}</li>
		{/if}
		</ul>
	</td>

	<td>
		{render partial="shared/active_state" object=$campaign}
	</td>

	<td>{!$campaign->getValidFrom()|format_datetime|default:"&mdash;"}</td>
	<td>{!$campaign->getValidTo()|format_datetime|default:"&mdash;"}</td>
	<td>{$campaign->getCreatedAt()|format_datetime}</td>

	<td>
		{dropdown_menu}
			{a action="edit" id=$campaign}{!"edit"|icon} {t}Upravit{/t}{/a}
			{if $campaign->isDeletable()}
				{a_destroy id=$campaign}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}
	</td>

</tr>
