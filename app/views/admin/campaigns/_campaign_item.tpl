<tr>
	<td>{$campaign->getId()}</td>

	<td>{$campaign->getRegions()|join:", "}</td>

	<td>{$campaign->getName()}</td>

	{* Obsah *}
	<td>
		<ul>
		{if $campaign->freeShipping()}
			<li>{t}doprava zdarma{/t}</li>
		{/if}
		{if $campaign->getDiscountPercent()}
			<li>{t discount_percent=$campaign->getDiscountPercent()}sleva %1%{/t}</li>
		{/if}
		</ul>
	</td>

	{* Podminky *}
	<td>
		<ul>
			{if $campaign->userRegistrationRequired()}
				<li>{t}pouze pro přihlášené{/t}</li>
			{else}
				<li>{t}i pro neregistrované{/t}</li>
			{/if}
			{if $campaign->getMinimalItemsPriceInclVat()}
				{assign currency Currency::GetDefaultCurrency()}
				<li>{t price=$campaign->getMinimalItemsPriceInclVat()|display_price:"$currency,format=plain"}minimální výše objednávky %1{/t}</li>
			{else}
				<li>{t}bez omezení výše objednávky{/t}</li>
			{/if}
			{if $campaign->getDeliveryMethod()}
				<li>{t dm=$campaign->getDeliveryMethod()}pouze pro dopravu %1{/t}</li>
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
