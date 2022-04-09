{assign incl_vat $basket->displayPricesInclVat()}

		<tfoot>

			<tr class="table-products__tfootstart">
				<td colspan="{if $incl_vat}4{else}5{/if}" class="text-center table-products__free-shipping">
					{if $basket->freeShipping()}
						<div class="sticker sticker--free-shipping">
							<div class="sticker__icon">{!"truck"|icon}</div>
							<h4 class="sticker__title">{t}Doprava{/t}</h4>
							<div class="sticker__text">
								{t}Zdarma{/t}
							</div>
							<div class="sticker__icon">{!"check"|icon}</div>
						</div>
					{/if}
				</td>
				<td colspan="2" class="text-right table-products__price-summary" id="js--basket_price_summarization">
					<table>
						<tbody>
							<tr>
								<th class="text--nowrap">
									{if $incl_vat}
										{t escape=no}Cena za zboží<span class="text-muted"> vč. DPH</span>{/t}
									{else}
										{t escape=no}Cena za zboží<span class="text-muted"> bez DPH</span>{/t}
									{/if}
								</th>
								<td class="text-right">{!$basket->getItemsPriceBeforeDiscount($incl_vat)|display_price:"$currency,summary"}</td>
							</tr>

							{if ($basket->getItemsPrice($incl_vat) - $basket->getItemsPriceBeforeDiscount($incl_vat) - $basket->getVouchersDiscountAmount($incl_vat) - $basket->getCampaignsDiscountAmount($incl_vat))!=0.0}
							<tr>
								<th class="text--red">{t}Slevy celkem{/t}</th>
								<td class="text-right text--red">{!($basket->getItemsPrice($incl_vat) - $basket->getItemsPriceBeforeDiscount($incl_vat) - $basket->getVouchersDiscountAmount($incl_vat) - $basket->getCampaignsDiscountAmount($incl_vat))|display_price:"$currency,summary"}</td>
							</tr>
							<tr>
								<th>{t}Cena zboží celkem{/t}</th>
								<td class="text-right">{!($basket->getItemsPrice($incl_vat) - $basket->getVouchersDiscountAmount($incl_vat) - $basket->getCampaignsDiscountAmount($incl_vat))|display_price:"$currency,summary"}</td>
							</tr>
							{/if}

							{if !is_null($basket->getShippingFee())}
							<tr>
								<th class="{if $basket->freeShipping()}text-success{/if}">{t}Doprava{/t}</th>
								<td class="text-right {if $basket->freeShipping()}text-success{/if}">{!$basket->getShippingFee($incl_vat)|display_price:"$currency,summary"|default:"&mdash;"}</td>
							</tr>
							{/if}

							<tr>
								<th class="table-products__pricetopay">{if $incl_vat}{t}Cena celkem{/t}{else}{t}Cena celkem vč. DPH{/t}{/if}</th>
								<td class="table-products__pricetopay">{!$basket->getPriceToPay()|display_price:"$currency,summary"}</td>
							</tr>
						</tbody>
					</table>
				</td>
				{* Prazdne td jako placeholder sloupecku "actions" v tbody *}
				<td class="table-products__item-actions"></td>
			</tr>
			
			<tr>
				<td colspan="{if $incl_vat}7{else}8{/if}" class="table-products__addvoucher">
					<div class="vouchers"{if isset($vouchers_anchor_set) && !$vouchers_anchor_set} id="vouchers"{/if}>
						<h4>{t}Slevové kupóny / dárkové poukazy{/t}</h4>
						<div class="input-group input-group--voucher">
							{!$form|field:"voucher"}
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary text--nowrap">{t}Použít kód{/t}</button>
							</span>
						</div>
					</div>
				</td>
			</tr>

			<tr>
				<td colspan="{if $incl_vat}7{else}8{/if}">
					{render partial="shared/form_field" field="note"}
				</td>
			</tr>
			
		</tfoot>
