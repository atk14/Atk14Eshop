		<tfoot>

			<tr class="table-products__tfootstart">
				<td colspan="4" class="text-center table-products__free-shipping">
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
								<th class="text--nowrap">{t escape=no}Cena za zboží<span class="text-muted"> vč. DPH</span>{/t}</th>
								<td class="text-right">{!$basket->getItemsPriceBeforeDiscountInclVat()|display_price:"$currency,summary"}</td>
							</tr>

							{if ($basket->getItemsPriceInclVat() - $basket->getItemsPriceBeforeDiscountInclVat() - $basket->getVouchersDiscountAmount() - $basket->getCampaignsDiscountAmount())!=0.0}
							<tr>
								<th class="text--red">{t}Slevy celkem{/t}</th>
								<td class="text-right text--red">{!($basket->getItemsPriceInclVat() - $basket->getItemsPriceBeforeDiscountInclVat() - $basket->getVouchersDiscountAmount() - $basket->getCampaignsDiscountAmount())|display_price:"$currency,summary"}</td>
							</tr>
							<tr>
								<th>{t}Cena zboží celkem{/t}</th>
								<td class="text-right">{!($basket->getItemsPriceInclVat() - $basket->getVouchersDiscountAmount() - $basket->getCampaignsDiscountAmount())|display_price:"$currency,summary"}</td>
							</tr>
							{/if}

							<tr>
								<th class="{if $basket->freeShipping()}text-success{/if}">{t}Doprava{/t}</th>
								<td class="text-right {if $basket->freeShipping()}text-success{/if}">{!$basket->getShippingFeeInclVat()|display_price:"$currency,summary"|default:"&mdash;"}</td>
							</tr>
							<tr>
								<th class="table-products__pricetopay">{t}Cena celkem{/t}</th>
								<td class="table-products__pricetopay">{!$basket->getPriceToPay()|display_price:"$currency,summary"}</td>
							</tr>
						</tbody>
					</table>
				</td>
				{* Prazdne td jako placeholder sloupecku "actions" v tbody *}
				<td class="table-products__item-actions"></td>
			</tr>
			
			<tr>
				<td colspan="7" class="table-products__addvoucher">
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
				<td colspan="7">
					{render partial="shared/form_field" field="note"}
				</td>
			</tr>
			
		</tfoot>
