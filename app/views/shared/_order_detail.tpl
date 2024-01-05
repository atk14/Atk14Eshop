{*
 * Detail objednavky nebo kosiku
 *}
{if !isset($show_note)}
	{assign show_note true}
{/if}

{assign currency $order->getCurrency()}
{assign vouchers $order->getVouchers()}
{assign campaigns $order->getCampaigns()}
{assign object_class get_class($order)}
{assign is_basket $object_class=="Basket"}
{assign tag_digital_product Tag::GetInstanceByCode("digital_product")}
{assign incl_vat $basket->displayPricesInclVat()}

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
			<th class="table-products__unit-price">{if $incl_vat}{t}Jedn. cena{/t}{else}{t}Jedn. cena bez DPH{/t}{/if}</th>
			{if !$incl_vat}
			<th class="table-products__vat-percent">{t escape=no}%&nbsp;DPH{/t}</th>
			{/if}
			<th class="table-products__amount">{t}Množství{/t}</th>
			<th class="table-products__price">{if $incl_vat}{t}Celkem{/t}{else}{t}Celkem bez DPH{/t}{/if}</th>
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
					{if !$incl_vat}
					<td class="table-products__vat-percent"></td>
					{/if}
					<td class="table-products__amount"></td>
					<td class="table-products__price">{!$item->getPrice($incl_vat)|display_price:"$currency"}</td>
				{else}
					<td class="table-products__image"><a href="{$product|link_to_product}" aria-label="{$product->getName()} - {t}Product detail{/t}">{!$product->getImage()|pupiq_img:"120x120x#ffffff"}</a></td>
					<td class="table-products__title">
						<a href="{$product|link_to_product}">{$product->getName()}</a>
						{if $product->getCard()->containsTag($tag_digital_product)}
							<br><small><span class="badge badge-pill badge-secondary">{$tag_digital_product->getTagLocalized()}</span></small>
						{/if}
						<span class="d-block d-lg-none table-products__id"><span class="property__key">{t}Kód{/t}</span>{$product->getCatalogId()}</span>
					</td>
					<td class="table-products__id"><span class="d-none d-lg-inline">{$product->getCatalogId()}</span></td>
					<td class="table-products__unit-price"><span class="property__key">{t}Jedn. cena{/t}</span> {!$item->getUnitPrice($incl_vat)|display_price:$currency}</td>
					{if !$incl_vat}
					<td class="table-products__vat-percent">{$item->getVatPercent()}</td>
					{/if}
					<td class="table-products__amount"><span class="property__key">{t}Množství{/t}</span>{$item->getAmount()}</td>
					<td class="table-products__price"><span class="property__key">{t}Celkem{/t}</span>{!$item->getPrice($incl_vat)|display_price:"$currency"}</td>
				{/if}
			</tr>
		{/foreach}

		{* an order already has possible gifts in its items *}
		{if is_a($order,"Basket")}
			{foreach $order->getCampaigns() as $campaign}
				{assign product $campaign->getGiftProduct()}
				{if $product}
					<tr class="table-products__item">
						<td class="table-products__image"><a href="{$product|link_to_product}">{!$product->getImage()|pupiq_img:"120x120x#ffffff"}</a></td>
						<td class="table-products__title">
							<a href="{$product|link_to_product}">{$product->getName()}</a>
							{if $product->getCard()->containsTag($tag_digital_product)}
								<br><small><span class="badge badge-pill badge-secondary">{$tag_digital_product->getTagLocalized()}</span></small>
							{/if}
							<span class="d-block d-lg-none table-products__id"><span class="property__key">{t}Kód{/t}</span>{$product->getCatalogId()}</span>
						</td>
						<td class="table-products__id"><span class="d-none d-lg-inline">{$product->getCatalogId()}</span></td>
						<td class="table-products__unit-price"><span class="property__key">{t}Jedn. cena{/t}</span> {!0.0|display_price:$currency}</td>
						{if !$incl_vat}
						<td class="table-products__vat-percent">{$product->getVatPercent()}</td>
						{/if}
						<td class="table-products__amount"><span class="property__key">{t}Množství{/t}</span>{$campaign->getGiftAmount()}</td>
						<td class="table-products__price"><span class="property__key">{t}Celkem{/t}</span>{!0.0|display_price:"$currency"}</td>
					</tr>	
				{/if}
			{/foreach}
		{/if}
	</tbody>
	
	<tbody class="table-products__discounts">{trim}
		{foreach $campaigns as $campaign}
			{if $campaign->getDiscountAmount($incl_vat)}
			<tr class="table-products__item table-products__item--sale">
				<td class="table-products__icon">{!"percentage"|icon}</td>
				<td class="table-products__title" colspan="{if $incl_vat}4{else}5{/if}">{$campaign->getName()}</td>
				<td class="table-products__price">{!(-$campaign->getDiscountAmount($incl_vat))|display_price:"$currency"}</td>
			</tr>
			{/if}
		{/foreach}

		{foreach $vouchers as $voucher}
			<tr class="table-products__item table-products__item--sale">
				<td class="table-products__icon">{!$voucher->getIconSymbol()|icon}</td>
				<td class="table-products__title">{$voucher->getDescription()}</td>
				<td colspan="{if $incl_vat}3{else}4{/if}" class="table-products__id">{$voucher}</td>
				<td class="table-products__price">{if $voucher->getDiscountAmount($incl_vat)}{!(-$voucher->getDiscountAmount($incl_vat))|display_price:"$currency"}{/if}</td>
			</tr>
		{/foreach}
	{/trim}</tbody>
	
	<tbody class="table-products__delivery-payment">
		<tr class="table-products__item">
			<td class="table-products__icon">{!"truck"|icon}</td>
			<td class="table-products__title">{t}Doprava:{/t}</td>
			<td colspan="{if $incl_vat}3{else}4{/if}" class="table-products__id">{$order->getDeliveryMethod()->getLabel()}{render partial="shared/order/delivery_method_data" show_branch_id=false}</td>
			<td class="table-products__price">{!$order->getDeliveryFee($incl_vat)|display_price:"$currency"|default:$mdash}</td>
		</tr>
		{if $is_basket==false && $order->getDeliveryMethod()->getTrackingUrl()}
			{assign tracking_url $order->getTrackingUrl()}
			<tr class="table-products__item">
				<td class="table-products__icon"></td>
				<td class="table-products__title">{t}Číslo zásilky{/t}:</td>
				<td colspan="{if $incl_vat}4{else}5{/if}">
					{if $tracking_url}<a href="{$order->getTrackingUrl()}">{$order->getTrackingNumber()}</a>{else}{t}Není zadáno{/t}{/if}
				</td>
			</tr>
		{/if}
		
		<tr class="table-products__item">
			<td class="table-products__icon">{!"wallet"|icon}</td>
			<td class="table-products__title">{t}Platba:{/t}</td>
			<td colspan="{if $incl_vat}3{else}4{/if}">{$order->getPaymentMethod()->getLabel()}</td>
			<td class="table-products__price">{!$order->getPaymentFee($incl_vat)|display_price:"$currency"}</td>
		</tr>
	</tbody>
	
	<tfoot>
		<tr class="table-products__tfootstart">
			{strip}
			<td colspan="{if $incl_vat}3{else}4{/if}" class="table-products__note">
				{if $show_note && $order->getNote()}
					<em>{!$order->getNote()|h|nl2br}</em>
				{/if}
			</td>
			{/strip}
			<td colspan="{if $incl_vat}3{else}4{/if}" class="text-right table-products__price-summary">
				<table>
					<tbody>
						<tr>
							<th>{if $incl_vat}{t escape=no}Cena za zboží<span class="text-muted"> vč. DPH</span>{/t}{else}{t escape=no}Cena za zboží<span class="text-muted"> bez DPH</span>{/t}{/if}</th>
							<td class="text-right">{!$order->getItemsPrice($incl_vat)|display_price:"$currency"}</td>
						</tr>
						<tr>
							<th>{t}Doprava a platba{/t}</th>
							<td class="text-right">{!$order->getShippingFee($incl_vat)|display_price:"$currency"|default:$mdash}</td>
						</tr>
						{if $order->getCampaignsDiscountAmount()}
						<tr>
							<th>{t}Slevová kampaň{/t}</th>
							<td class="text-right">{!(-$order->getCampaignsDiscountAmount($incl_vat))|display_price:"$currency"}</td>
						</tr>
						{/if}
						{if $order->getVouchersDiscountAmount()}
						<tr>
							<th>{if sizeof($vouchers)>1}{t}Slevové kupóny{/t}{else}{t}Slevový kupón{/t}{/if}</th>
							<td class="text-right">{!(-$order->getVouchersDiscountAmount($incl_vat))|display_price:"$currency"}</td>
						</tr>
						{/if}
						<tr>
							<th class="table-products__pricetopay">{if $incl_vat}{t}Cena celkem{/t}{else}{t}Cena celkem vč. DPH{/t}{/if}</th>
							<td class="table-products__pricetopay text-right">{!$order->getPriceToPay()|display_price:"$currency,summary=auto"}{if is_null($order->getShippingFee())}<sup>*</sup>{/if}</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tfoot>
</table>

{if is_null($order->getShippingFee())}
	<p class="text-right">
		<small><sup>*</sup> {t}Uvedená konečná cena neobsahuje poplatek za dopravu.{/t}</small></td>
	</p>
{/if}


<div class="checkout-summary__addresses">
	<div class="row">
		<div class="col-12 col-md">
			<h5 class="h5">{!"map-marker-alt"|icon} {t}Doručovací adresa:{/t}</h5>
			<p>
				{render partial="shared/delivery_address" object_with_delivery_address=$order}
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
				{$order->getAddressZip()} {$order->getAddressCity()}<br>
				{if $order->getAddressState()|strlen}
					{$order->getAddressState()}<br>
				{/if}
				{$order->getAddressCountry()|to_country_name}<br>
				{if $order->getCompanyNumber() || $order->getVatId()}
					{t}IČ:{/t} {$order->getCompanyNumber()}<br>
					{t}DIČ:{/t} {$order->getVatId()}
				{/if}
			</p>
		</div>
	</div>
</div>
