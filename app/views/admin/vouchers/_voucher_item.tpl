<tr>
	<td>{$voucher->getId()}</td>
	<td>{$voucher->getVoucherCode()}</td>
	<td>
		{if $voucher->getDiscountPercent()}
			{!$voucher->getDiscountPercent()}%<br>
		{/if}
		{if $voucher->getDiscountAmount()}
			{!$voucher->getDiscountAmount()|display_price}<br>
		{/if}
		{if $voucher->freeShipping()}
			{t}doprava zdarma{/t}
		{/if}
	</td>
	<td>{render partial="shared/active_state" object=$voucher}</td>
	<td>{$voucher->hasBeenUsed()|display_bool}</td>
	<td>{!$voucher->getValidFrom()|format_datetime|default:"&mdash;"}</td>
	<td>{!$voucher->getValidTo()|format_datetime|default:"&mdash;"}</td>
	<td>{$voucher->getCreatedAt()|format_datetime}</td>
	<td>{$voucher->getCreatedByUser()}</td>
	<td>
		{dropdown_menu}
			{a action="edit" id=$voucher}{!"edit"|icon} {t}Upravit{/t}{/a}
			{if $voucher->isDeletable()}
				{a_destroy id=$voucher}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}
	</td>
</tr>
