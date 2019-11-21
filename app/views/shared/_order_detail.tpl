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
			<th class="table-products__image"><span class="sr-only">{t}Obrázek{/t}</span></th>
			<th class="table-products__title">{t}Produkt{/t}<span class="d-block d-lg-none">{t}Kód{/t}</span></th>
			<th class="table-products__id">{t}Kód{/t}</th>
			<th class="table-products__unit-price">{t}Jedn. cena{/t}</th>
			<th class="table-products__amount">{t}Množství{/t}</th>
			<th class="table-products__price">{t}Celkem{/t}</th>
		</tr>
	</thead>
	<tbody class="table-products__list">
		{foreach $order->getItems() as $item}
			{assign product $item->getProduct()}
			<tr class="table-products__item">
				{if $product->getCode()=="price_rounding"}
					{* toto je spec. produkt zaokrouhleni *}
					<td class="table-products__image"></td>
					<td class="table-products__title">{$product->getName()}</td>
					<td class="table-products__id"></td>
					<td class="table-products__unit-price"></td>
					<td class="table-products__amount"></td>
					<td class="table-products__price">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
				{else}
					<td class="table-products__image">{a action="cards/detail" id=$product->getCardId()}{!$product->getImage()|pupiq_img:"120x120x#ffffff"}{/a}</td>
					<td class="table-products__title">{a action="cards/detail" id=$product->getCardId()}{$product->getName()}{/a}<span class="d-block d-lg-none table-products__id"><span class="property__key">{t}Kód{/t}</span>{$product->getCatalogId()}</span></td>
				<td class="table-products__id"><span class="d-none d-lg-inline">{$product->getCatalogId()}</span></td>
					<td class="table-products__unit-price"><span class="property__key">{t}Jedn. cena{/t}</span> {!$item->getUnitPriceInclVat()|display_price:$currency}</td>
					<td class="table-products__amount"><span class="property__key">{t}Množství{/t}</span>{$item->getAmount()}</td>
					<td class="table-products__price"><span class="property__key">{t}Celkem{/t}</span>{!$item->getPriceInclVat()|display_price:"$currency"}</td>
				{/if}
			</tr>
		{/foreach}
	</tbody>
	
	<tbody class="table-products__discounts">{trim}
		{foreach $campaigns as $campaign}
			{if $campaign->getDiscountAmount()}
			<tr class="table-products__item table-products__item--sale">
				<td class="table-products__icon">{!"percentage"|icon}</td>
				<td class="table-products__title" colspan="4">{$campaign->getName()}</td>
				<td class="table-products__price">{!(-$campaign->getDiscountAmount())|display_price:"$currency"}</td>
			</tr>
			{/if}
		{/foreach}

		{foreach $vouchers as $voucher}
			<tr class="table-products__item table-products__item--sale">
				<td class="table-products__icon">{!"percentage"|icon}</td>
				<td class="table-products__title">{t}Slevový kupón{/t}</td>
				<td colspan="3" class="table-products__id">{$voucher}</td>
				<td class="table-products__price">{!(-$voucher->getDiscountAmount())|display_price:"$currency"}</td>
			</tr>
		{/foreach}
	{/trim}</tbody>
	
	<tbody class="table-products__delivery-payment">
		<tr class="table-products__item">
			<td class="table-products__icon">{!"truck"|icon}</td>
			<td class="table-products__title">{t}Doprava:{/t}</td>
			<td colspan="3" class="table-products__id">{$order->getDeliveryMethod()->getLabel()}{render partial="shared/order/delivery_method_data" show_branch_id=false}</td>
			<td class="table-products__price">{!$order->getDeliveryFeeInclVat()|display_price:"$currency"}</td>
		</tr>
		{if $is_basket==false && $order->getDeliveryMethod()->getTrackingUrl()}
			{assign tracking_url $order->getTrackingUrl()}
			<tr class="table-products__item">
				<td class="table-products__icon"></td>
				<td class="table-products__title">{t}Číslo zásilky{/t}:</td>
				<td colspan="4">
					{if $tracking_url}<a href="{$order->getTrackingUrl()}">{$order->getTrackingNumber()}</a>{else}{t}Není zadáno{/t}{/if}
				</td>
			</tr>
		{/if}
		<tr class="table-products__item">
				<td class="table-products__icon"></td>
				<td class="table-products__title">{t}Číslo zásilky{/t}:</td>
				<td colspan="4">
					<a href="#">45545465FAKE</a>
				</td>
			</tr>
		
		<tr class="table-products__item">
			<td class="table-products__icon">{!"wallet"|icon}</td>
			<td class="table-products__title">{t}Platba:{/t}</td>
			<td colspan="3">{$order->getPaymentMethod()->getLabel()}</td>
			<td class="table-products__price">{!$order->getPaymentFeeInclVat()|display_price:"$currency"}</td>
		</tr>
	</tbody>
	
	<tfoot>
		<tr class="table-products__tfootstart">
			{strip}
			<td colspan="3" class="table-products__note"><em>Fake note: zvonit aspon dvakrat! Pozor zly pes!</em>
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


<div class="checkout-summary__addresses">
	<div class="row">
		<div class="col-12 col-md">
			<h5 class="h5">{!"map-marker-alt"|icon} {t}Doručovací adresa:{/t}</h5>
			<p>
				{$order->getDeliveryFirstname()} {$order->getDeliveryLastname()}<br>
				{if $order->getDeliveryCompany()}
					{$order->getDeliveryCompany()}<br>
				{/if}
				{$order->getDeliveryAddressStreet()}<br>
				{if $order->getDeliveryAddressStreet2()}
							{$order->getDeliveryAddressStreet2()}<br>
				{/if}
				{$order->getDeliveryAddressCity()}<br>
				{$order->getDeliveryAddressZip()}<br>
				{$order->getDeliveryAddressCountry()|to_country_name}<br>
				{if $order->getDeliveryPhone()}
					{$order->getDeliveryPhone()|default:$mdash}
				{/if}
			</p>
		</div>
		<div class="col-12 col-md">
			<h5 class="h5">{t}Fakturační údaje:{/t}</h5>
			<p>
				{if $order->getCompany()}
					{$order->getCompany()}<br>
				{else}
					{$order->getFirstname()} {$order->getLastname()}<br>
				{/if}
				{$order->getAddressStreet()}<br>
				{if $order->getAddressStreet2()}
					{$order->getAddressStreet2()}<br>
				{/if}
				{$order->getAddressCity()}<br>
				{$order->getAddressZip()}<br>
				{$order->getAddressCountry()|to_country_name}<br>
				{if $order->getCompanyNumber() || $order->getVatId()}
					{t}IČ:{/t} {$order->getCompanyNumber()}<br>
					{t}DIČ:{/t} {$order->getVatId()}
				{/if}
			</p>
		</div>
	</div>
</div>