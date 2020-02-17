		{* trim is here to enable detect empty (=no whitespace) tbody tag by css when there are no discounts so we can use :empty css rules *}
		<tbody class="table-products__discounts">{trim}
			{* Kampane *}
			{foreach $basket_campaigns as $campaign}
				{if $campaign->getDiscountAmount()>0.0}
				<tr class="table-products__item table-products__item--sale">
					<td class="table-products__icon">{!"percentage"|icon}</td>
					<td colspan="4" class="table-products__title">{$campaign->getName()}</td>
					<td class="table-products__price text-success">{!(-$campaign->getDiscountAmount())|display_price:$currency}</td>
					<td class="table-products__item-actions"></td>
				</tr>
				{/if}
			{/foreach}

			{* Vouchery, slevove kupony *}
			{foreach $basket_vouchers as $voucher}
				<tr class="table-products__item table-products__item--sale"{if isset($vouchers_anchor_set) && !$vouchers_anchor_set} id="vouchers"{assign vouchers_anchor_set 1}{/if}>
					<td class="table-products__icon">{!"percentage"|icon}</td>
					<td colspan="2" class="table-products__title">{t}Slevový kupón{/t}</td>
					<td colspan="2" class="table-products__id">{t}slevový kód č.{/t}&nbsp;<strong>{$voucher}</strong></td>
					<td class="table-products__price text-success">{!(-$voucher->getDiscountAmount())|display_price:$currency}</td>
					<td class="table-products__item-actions">
						{a namespace="" action="basket_vouchers/destroy" id=$voucher _method=post _confirm="{t}Opravdu chcete odstranit tento slevový kupón z nákupního košíku?{/t}" _title="{t}odstranit z košíku{/t}"}{!"remove"|icon}{/a}
					</td>
				</tr>
			{/foreach}
		{/trim}</tbody>
