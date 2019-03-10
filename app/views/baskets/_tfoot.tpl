		<tfoot>


			{* Kampane *}
			{foreach $basket_campaigns as $campaign}
				{if $campaign->getDiscountAmount()>0.0}
				<tr class="table-products__item table-products__item--sale">
					<td>&nbsp;</td>
					<td colspan="4" class="table-products__title">{$campaign->getName()}</td>
					<td class="table-products__price text-success">{!(-$campaign->getDiscountAmount())|display_price:$currency}</td>
					<td class="table-products__item-actions"></td>
				</tr>
				{/if}
			{/foreach}

			{* Vouchery, slevove kupony *}
			{foreach $basket_vouchers as $voucher}
				<tr class="table-products__item table-products__item--sale"{if isset($vouchers_anchor_set) && !$vouchers_anchor_set} id="vouchers"{assign vouchers_anchor_set 1}{/if}>
					<td><span class="icon icon--percent"></span></td>
					<td colspan="2" class="table-products__title">{t}Slevový kupón{/t}</td>
					<td colspan="2" class="table-products__id">{t}slevový kód č.{/t}&nbsp;<strong>{$voucher}</strong></td>
					<td class="table-products__price text-success">{!(-$voucher->getDiscountAmount())|display_price:$currency}</td>
					<td class="table-products__item-actions">
						{a namespace="" action="basket_vouchers/destroy" id=$voucher _method=post _confirm="{t}Opravdu chcete odstranit tento slevový kupón z nákupního košíku?{/t}" _title="{t}odstranit z košíku{/t}"}<i class="icon ion-close"></i>{/a}
					</td>
				</tr>
			{/foreach}

			<tr class="table-products__tfootstart">
				<td colspan="2" class="table-products__addvoucher">
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
				<td colspan="2" class="text-center table-products__free-shipping">
					{if $basket->freeShipping()}
						<h4>{t}Doprava{/t}</h4>
						<strong class="text-success text-uppercase text--large">
							<i class="icon ion-checkmark icon-lg"></i> {t}Zdarma{/t}
						</strong>
					{/if}
				</td>
				<td colspan="2" class="text-right table-products__price-summary">
					<table>
						<tbody>
							<tr>
								<th class="text--nowrap">{t escape=no}Cena za zboží<span class="text-muted"> vč. DPH</span>{/t}</th>
								<td class="text-right">{!$basket->getItemsPriceBeforeDiscountInclVat()|display_price:"$currency,summary"}</td>
							</tr>
							<tr>
								<th class="text--red">{t}Slevy celkem{/t}</th>
								<td class="text-right text--red">{!($basket->getItemsPriceInclVat() - $basket->getItemsPriceBeforeDiscountInclVat() - $basket->getVouchersDiscountAmount() - $basket->getCampaignsDiscountAmount())|display_price:"$currency,summary"}</td>
							</tr>
							<tr>
								<th>{t}Cena zboží celkem{/t}</th>
								<td class="text-right">{!($basket->getItemsPriceInclVat() - $basket->getVouchersDiscountAmount() - $basket->getCampaignsDiscountAmount())|display_price:"$currency,summary"}</td>
							</tr>
							<tr>
								<th class="{if $basket->freeShipping()}text-success{/if}">{t}Doprava{/t}</th>
								<td class="text-right {if $basket->freeShipping()}text-success{/if}">{!$basket->getShippingFeeInclVat()|display_price:"$currency,summary"|default:"&mdash;"}</td>
							</tr>
							<tr>
								<th class="table-products__pricetopay">{t}Cena celkem{/t}</th>
								<td class="table-products__pricetopay text-right">{!$basket->getPriceToPay()|display_price:"$currency,summary"}</td>
							</tr>
						</tbody>
					</table>
				</td>
				{* Prazdne td jako placeholder sloupecku "actions" v tbody *}
				<td></td>
			</tr>

		</tfoot>
