<tr>
	{highlight_search_query}
	<td>{highlight_search_query}{$voucher->getId()}{/highlight_search_query}</td>
	<td>{", "|join:$voucher->getRegions()}</td>
	<td>{if $voucher->isGiftVoucher()}{!"gift"|icon}{/if}</td>
	<td>{$voucher->getVoucherCode()}</td>
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
	{/highlight_search_query}
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
		{render partial="dropdown_menu"}
	</td>
</tr>
