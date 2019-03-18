{*
 * Detail objednavky nebo kosiku
 *}

{assign currency $order->getCurrency()}
{assign vouchers $order->getVouchers()}
{assign campaigns $order->getCampaigns()}
{assign object_class $order|get_class}
{assign is_basket $object_class=="Basket"}


{*
 * Tohle neni v designu
 *
 * <h3>{if $user}{t}Zákazník{/t}{else}{t}Nákup bez registrace{/t}{/if}</h3>
 * <p>
 * 	{$order->getFirstname()} {$order->getLastname()}<br>
 * 	{t}e-mail:{/t} {$order->getEmail()}<br>
 * 	{t}telefon:{/t} {!$order->getPhone()|h|default:"&mdash;"}<br>
 * </p>
 *}

<table class="table-products table-products--main">
	<caption class="sr-only">{t}Objednávané zboží{/t}</caption>
	<thead>
		<tr>
			<th>{t}Produkt{/t}</th>
			<th>{t}Popis{/t}</th>
			<th class="text-center">{t}Kód{/t}</th>
			<th class="text-right text--nowrap">{t}Cena [cm/ks]{/t}</th>
			<th class="text-right text--nowrap">{t}Mn. [cm/ks]{/t}</th>
			<th class="text-right">{t}Celkem{/t}</th>
		</tr>
	</thead>
	<tbody class="table-products__list">
		{foreach $order->getItems() as $item}
			{assign product $item->getProduct()}
			<tr class="table-products__item">
				{if $product->getCode()=="price_rounding"}
					{* toto je spec. produkt zaokrouhleni *}
					<td class="table-products__img"></td>
					<td class="table-products__title">{$product->getName()}</td>
					<td class="table-products__id"></td>
					<td class="table-products__unit-price"></td>
					<td class="table-products__amount"></td>
					<td class="table-products__price">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
				{else}
					<td class="table-products__img">{a action="cards/detail" id=$product->getCardId()}{!$product->getImage()|pupiq_img:"60x60x#ffffff"}{/a}</td>
					<td class="table-products__title">{a action="cards/detail" id=$product->getCardId()}{$product->getName()}{/a}</td>
					<td class="table-products__id">{$product->getCatalogId()}</td>
					<td class="table-products__unit-price">{!$item->getUnitPriceInclVat()|display_price:$currency}</td>
					<td class="table-products__amount">{$item->getAmount()}</td>
					<td class="table-products__price">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
				{/if}
			</tr>
		{/foreach}
	</tbody>
	<tfoot>
		{foreach $campaigns as $campaign}
			{if $campaign->getDiscountAmount()}
			<tr class="table-products__item table-products__item--sale">
				<td class="table-products__img"></td>
				<td class="table-products__title" colspan="2">{$campaign->getName()}</td>
				<td class="text-right"></td>
				<td class="table-products__amount"></td>
				<td class="table-products__price">{!(-$campaign->getDiscountAmount())|display_price:"$currency"}</td>
			</tr>
			{/if}
		{/foreach}

		{foreach $vouchers as $voucher}
			<tr class="table-products__item table-products__item--sale">
				<td class="table-products__img"></td>
				<td class="table-products__title">{t}Slevový kupón{/t}</td>
				<td class="table-products__id">{$voucher}</td>
				<td class="text-right"></td>
				<td class="table-products__amount"></td>
				<td class="table-products__price">{!(-$voucher->getDiscountAmount())|display_price:"$currency"}</td>
			</tr>
		{/foreach}
		<tr class="table-products__item">
			<td>{t}Doprava:{/t}</td>
			<td colspan="4">{$order->getDeliveryMethod()->getLabel()}{render partial="shared/order/delivery_method_data" show_branch_id=false}</td>
			<td class="text-right">{!$order->getDeliveryFeeInclVat()|display_price:"$currency"}</td>
		</tr>
		{if $is_basket==false && $order->getDeliveryMethod()->getTrackingUrl()}
			{assign tracking_url $order->getTrackingUrl()}
			<tr class="table-products__item">
				<td>{t}Číslo zásilky{/t}:</td>
				<td colspan="5">
					{if $tracking_url}<a href="{$order->getTrackingUrl()}">{$order->getTrackingNumber()}</a>{else}{t}Není zadáno{/t}{/if}
				</td>
			</tr>
		{/if}
		<tr class="table-products__item">
			<td>{t}Platba:{/t}</td>
			<td colspan="4">{$order->getPaymentMethod()->getLabel()}</td>
			<td class="text-right">{!$order->getPaymentFeeInclVat()|display_price:"$currency"}</td>
		</tr>
		<tr class="table-products__item">
			<td class="text--nowrap">{t}Doručovací adresa:{/t}</td>
			<td colspan="5">
				<ul class="list list--inline-psv list--location">
					<li class="list__item">{$order->getDeliveryFirstname()} {$order->getDeliveryLastname()}</li>
					{if $order->getDeliveryCompany()}
						<li class="list__item">{$order->getDeliveryCompany()}</li>
					{/if}
					<li class="list__item">{$order->getDeliveryAddressStreet()}</li>
					{if $order->getDeliveryAddressStreet2()}
						<li class="list__item">{$order->getDeliveryAddressStreet2()}</li>
					{/if}
					<li class="list__item">{$order->getDeliveryAddressCity()}</li>
					<li class="list__item">{$order->getDeliveryAddressZip()}</li>
					<li class="list__item">{$order->getDeliveryAddressCountry()|to_country_name}</li>
					<li class="list__item">
						{if $order->getDeliveryPhone()}{$order->getDeliveryPhone()|default:$mdash}{/if}
					</li>
				</ul>
			</td>
		</tr>
		<tr class="table-products__item">
			<td>{t}Fakturační údaje:{/t}</td>
			<td colspan="5">
				<ul class="list list--inline-psv list--location">
					<li class="list__item">
						{if $order->getCompany()}
							{$order->getCompany()}
						{else}
							{$order->getFirstname()} {$order->getLastname()}
						{/if}
					</li>
					<li class="list__item">
						{$order->getAddressStreet()}
					</li>
					{if $order->getAddressStreet2()}
					<li class="list__item">
						{$order->getAddressStreet2()}
					</li>
					{/if}
					<li class="list__item">
						{$order->getAddressCity()}
					</li>
					<li class="list__item">
						{$order->getAddressZip()}
					</li>
					<li class="list__item">
						{$order->getAddressCountry()|to_country_name}
					</li>
					{if $order->getCompanyNumber() || $order->getVatId()}
					<li class="list__item">
						{t}IČ:{/t} {$order->getCompanyNumber()}<br>
						{t}DIČ:{/t} {$order->getVatId()}
					</li>	
					{/if}
				</ul>
			</td>
		</tr>
		<tr class="table-products__tfootstart">
			{strip}
			<td colspan="3">
				{if $order->getNote()}
					<em>{!$order->getNote()|h|nl2br}</em>
				{/if}
			</td>
			{/strip}
			<td colspan="3" class="text-right table-products__price-summary">
				<table>
					<tbody>
						<tr>
							<th>{t escape=no}Cena za zboží<span class="text-muted"> vč. DPH</span>{/t}</th>
							<td class="text-right">{!$order->getItemsPriceInclVat()|display_price:"$currency"}</td>
						</tr>
						<tr>
							<th>{t}Doprava a platba{/t}</th>
							<td class="text-right">{!$order->getShippingFeeInclVat()|display_price:"$currency"}</td>
						</tr>
						{if $order->getCampaignsDiscountAmount()}
						<tr>
							<th>{t}Slevová kampaň{/t}</th>
							<td class="text-right">{!(-$order->getCampaignsDiscountAmount())|display_price:"$currency"}</td>
						</tr>
						{/if}
						{if $order->getVouchersDiscountAmount()}
						<tr>
							<th>{if sizeof($vouchers)>1}{t}Slevové kupóny{/t}{else}{t}Slevový kupón{/t}{/if}</th>
							<td class="text-right">{!(-$order->getVouchersDiscountAmount())|display_price:"$currency"}</td>
						</tr>
						{/if}
						<tr>
							<th class="table-products__pricetopay">{t}Cena celkem{/t}</th>
							<td class="table-products__pricetopay text-right">{!$order->getPriceToPay()|display_price:"$currency,summary"}</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tfoot>
</table>
