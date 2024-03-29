{use layout="voucher_print"}

{if !$voucher_color_theme}
	{assign "voucher_color_theme" "blue"}
{/if}
{if $voucher->freeShipping()}
	{* pouzije se jako velky napis, pokud je voucher jen na dopravu zdarma *}
	{capture assign="amount_generic"}{t}DOPRAVA ZDARMA{/t}{/capture}
	{* pouzije se pokud je voucher na procenta nebo castku a zaroven s dopravou zdarma *}
	{capture assign="amount_notice"}{t}VČETNĚ POŠTOVNÉHO{/t}{/capture}
{/if}
{assign show_voucher_data 0}


{if $voucher->isGiftVoucher()} {* voucher na penize *}
	{assign voucher_type "gift"}
	{capture assign="main_title"}{t}Dárkový poukaz{/t}{/capture}
	{capture assign="amount_notice"}{t escape="no"}VČETNĚ POŠTOVNÉHO{/t}{/capture}
	{capture assign="subtitle_1"}{t dom=$domain escape="no"}Na veškerý sortiment e-shopu <strong>%1</strong>{/t}{/capture}
{elseif $voucher->getDiscountPercent()} {* voucher na slevu *}
	{assign voucher_type "discount"}
	{capture assign="main_title"}{t escape="no"}Slevový poukaz{/t}{/capture}
	{capture assign="subtitle_1"}{t dom=$domain escape="no"}Na veškerý sortiment e-shopu <strong>%1</strong>{/t}{/capture}
{else}
	{assign voucher_type "generic"} {* voucher na cokoliv jineho *}
	{capture assign="main_title"}{t escape="no"}Voucher{/t}{/capture}
	{capture assign="subtitle_1"}{t dom=$domain escape="no"}Na veškerý sortiment e-shopu <strong>%1</strong>{/t}{/capture}
{/if}

{assign has_barcode 1}

<div class="voucher voucher--{$voucher_color_theme} voucher--{$lang} voucher--{$voucher_type}{if $has_barcode} voucher--barcode{/if}">

	{*<img src="/public/dist/images/vouchers/voucher-bg--{$voucher_color_theme}.png" alt="" class="voucher__bg">*}
	<img src="/public/dist/images/vouchers/voucher_bg_180x90.jpg" alt="" class="voucher__bg">
	<!--img src="/public/dist/images/vouchers/template1.png" alt="" class="voucher__draft"/-->

	<div class="voucher__logo">
		{* render partial="shared/logo-universal.svg" *}
		<img src="/public/dist/images/header-logo.svg" alt="">
	</div>

	<div class="voucher__title">
		{!$main_title}
	</div>

	<div class="voucher__subtitle-1">
		{!$subtitle_1}
	</div>

	<div class="voucher__subtitle-2">
		{!$subtitle_2}
	</div>

	<div class="voucher__code">
		{$voucher->getVoucherCode()}
	</div>

	<div class="voucher__expiration">
		{if $voucher->getValidTo()}
			{$voucher->getValidTo()|format_date}
		{/if}
	</div>

	<div class="voucher__label-code">{t}*kód poukazu{/t}</div>
	<div class="voucher__label-expiration">{t}platnost do{/t}</div>

	<div class="voucher__help">{t}*Pro uplatnění poukazu zadejte kód při vytvoření objednávky.{/t}</div>

	{if $has_barcode}
		<div class="voucher__barcode">
			<img src="{barcode content=$voucher->getVoucherCode() w=2 h=30 type=C128}" alt="">
		</div>
	{/if}
	
	<div class="voucher__amount">
		<div>
			<div class="voucher__amount-main">
				{if $discount_amount}
					{!$discount_amount|display_price:"$currency,summary,hide_zero_cents"}
				{elseif $voucher->getDiscountPercent()}
					<div class="discount_main">
						<span class="discount_number">{$voucher->getDiscountPercent()}</span>&nbsp;%
					</div>
				{else}
					{!$amount_generic}
				{/if}
			</div>
			{if $voucher->freeShipping() && $voucher_type != "generic"}
				<div class="voucher__amount-notice">{$amount_notice}</div>
			{/if}
		</div>
	</div>
</div>

{if $show_voucher_data}
<table>
	<tr>
		<td>$voucher_type</td><td>{$voucher_type}</td>
	</tr>
	<tr>
		<td>$voucher_color_theme</td><td>{$voucher_color_theme}</td>
	</tr>
	<tr>
		<td>$lang</td><td>{$lang}</td>
	</tr>
	<tr>
		<td>$voucher->getVoucherCode()</td><td>{$voucher->getVoucherCode()}</td>
	</tr>
	<tr>
		<td>$voucher->getValidTo()|format_date</td><td>{$voucher->getValidTo()|format_date}</td>
	</tr>
	<tr>
		<td>$voucher->freeShipping()</td><td>{$voucher->freeShipping()}</td>
	</tr>
	<tr>
		<td>$voucher->getDiscountAmount()|display_price:$currency</td><td>{!$voucher->getDiscountAmount()}</td>
	</tr>
	<tr>
		<td>$voucher->getDiscountPercent()</td><td>{$voucher->getDiscountPercent()}</td>
	</tr>
	<tr>
		<td>$voucher->isGiftVoucher()</td><td>{$voucher->isGiftVoucher()}</td>
	</tr>
	<tr>
		<td>$amount_notice</td><td>{$amount_notice}</td>
	</tr>
</table>
{/if}
