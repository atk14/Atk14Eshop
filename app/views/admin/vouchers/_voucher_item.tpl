<tr>
	<td>{highlight_search_query}{$voucher->getId()}{/highlight_search_query}</td>
	<td>{", "|join:$voucher->getRegions()}</td>
	<td>{if $voucher->isGiftVoucher()}{!"gift"|icon}{/if}</td>
	<td>{{highlight_search_query}}{$voucher->getVoucherCode()}{/highlight_search_query}</td>
	<td>
		{if $voucher->getDiscountPercent()}
			{!$voucher->getDiscountPercent()}%<br>
		{/if}
		{if $voucher->getDiscountAmount()}
			{!$voucher->getDiscountAmount()|display_price}<br>
		{/if}
		{if $voucher->freeShipping()}
			{t}doprava zdarma{/t}<br>
		{/if}
		{if $voucher->getDescription()}
			<em>{$voucher->getDescription()|truncate:100}</em>
		{/if}
	</td>
	<td>{render partial="shared/active_state" object=$voucher}</td>
	<td>{$voucher->hasBeenUsed()|display_bool}
			{if $voucher->hasBeenUsed()}
				<span title="{t}Najít objednávky s tímto kupónem{/t}">{a action="orders/index" search=$voucher->getVoucherCode()}{!"external-link-alt"|icon} {/a}</span>
			{/if}
	</td>
	<td>{!$voucher->getValidFrom()|format_datetime|default:"&mdash;"}</td>
	<td>{!$voucher->getValidTo()|format_datetime|default:"&mdash;"}</td>
	<td>{$voucher->getCreatedAt()|format_datetime}</td>
	<td>{$voucher->getCreatedByUser()}</td>
	<td>
		{dropdown_menu}
			{a action="edit" id=$voucher}{!"edit"|icon} {t}Upravit{/t}{/a}
			<a href="{$voucher->getUrl()}">{!"eye-open"|icon} {t}Zobrazit náhled{/t}</a>
			{if $voucher->isDeletable()}
				{a_destroy id=$voucher}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}
	</td>
</tr>
