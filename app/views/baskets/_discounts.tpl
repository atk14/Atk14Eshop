{assign currency $basket->getCurrency()}
{assign incl_vat $basket->displayPricesInclVat()}

		{* trim is here to enable detect empty (=no whitespace) tbody tag by css when there are no discounts so we can use :empty css rules *}
		<tbody class="table-products__discounts">{trim}
			{* Kampane *}
			{foreach $basket_campaigns as $campaign}
				{if $campaign->getGiftProduct()}
					{assign product $campaign->getGiftProduct()}
					<tr class="table-products__item table-products__item--sale">
						<td class="table-products__image"><a href="{$product|link_to_product}">{!$product->getImage()|pupiq_img:"120x120x#ffffff"}</a></td>
						<td colspan="{if $incl_vat}3{else}4{/if}" class="table-products__title">
							<a href="{$product|link_to_product}"><strong>{$product->getName()}</strong></a>
						</td>
						<td class="table-products__amount" align="center">
							{$campaign->getGiftAmount()} {$product->getUnit()}
						</td>
						<td class="table-products__price text-success">{!0|display_price:$currency}</td>
						<td class="table-products__item-actions"></td>
					</tr>
				{/if}
				{if $campaign->getDiscountAmount()>0.0}
				<tr class="table-products__item table-products__item--sale">
					<td class="table-products__icon">{!"percentage"|icon}</td>
					<td colspan="{if $incl_vat}4{else}5{/if}" class="table-products__title">{$campaign->getName()}</td>
					<td class="table-products__price text-success">{!(-$campaign->getDiscountAmount())|display_price:$currency}</td>
					<td class="table-products__item-actions"></td>
				</tr>
				{/if}
			{/foreach}

			{* Vouchery, slevove kupony *}
			{foreach $basket_vouchers as $voucher}
				<tr class="table-products__item table-products__item--sale"{if isset($vouchers_anchor_set) && !$vouchers_anchor_set} id="vouchers"{assign vouchers_anchor_set 1}{/if}>
					<td class="table-products__icon">{!$voucher->getIconSymbol()|icon}</td>
					<td colspan="{if $incl_vat}2{else}3{/if}" class="table-products__title">{$voucher->getDescription()}</td>
					<td colspan="2" class="table-products__id">{if $voucher->getDiscountAmount() || $voucher->freeShipping()}{t}slevový kód č.{/t}{else}{t}dárkový kód č.{/t}{/if}&nbsp;<strong>{$voucher}</strong></td>
					<td class="table-products__price text-success">{if $voucher->getDiscountAmount()}{!(-$voucher->getDiscountAmount())|display_price:$currency}{/if}</td>
					<td class="table-products__item-actions">
						{a namespace="" action="basket_vouchers/destroy" id=$voucher _method=post _confirm="{t}Opravdu chcete odstranit tento slevový kupón z nákupního košíku?{/t}" _title="{t}odstranit z košíku{/t}"}{!"remove"|icon}{/a}
					</td>
				</tr>
			{/foreach}
		{/trim}</tbody>
