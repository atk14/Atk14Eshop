{render partial="shared/checkout_navigation"}

{render partial="shared/layout/content_header" title=$page_title}

{if $delivery_addresses}

<ul class="card-deck card-deck--sized-4 cards--addresses">
	{foreach $delivery_addresses as $da name=addresscounter}
		{assign addresscounter $smarty.foreach.addresscounter.iteration}
		<li class="card bg-light">
			<div class="card-body js--card-address {if $addresscounter == 1}card--active{/if}">
				{$da->getFirstname()} {$da->getLastname()}<br>
				{if $da->getCompany()}
					{$da->getCompany()}<br>
				{/if}
				{$da->getAddressStreet()}<br>
				{if $da->getAddressStreet2()}
					{$da->getAddressStreet2()}<br>
				{/if}
				{$da->getAddressCity()}<br>
				{$da->getAddressZip()}<br>
				{$da->getAddressCountry()|to_country_name}<br>
				{if $da->getAddressNote()}
					<em>{t}Poznámka:{/t} {$da->getAddressNote()}</em><br>
				{/if}
				{t}telefon:{/t} {$da->getPhone()|display_phone|default:$mdash}
			</div>
			<div class="card-footer card__actions justify-content-start">
				<button class="js--predefined-address card__action btn btn-primary btn-sm" data-json="{$da->toJson()}">{!"check"|icon} <span>{t}Použít{/t}</span></button>
				&nbsp;
					{a_destroy action="delivery_addresses/destroy" id=$da->getId() _title="{t}Smazat adresu{/t}" _confirm="{t}Opravdu chcete smazat tuto adresu?{/t}" _class="card__action btn btn-secondary btn-sm"}{!"remove"|icon} <span>{t}Smazat{/t}</span>{/a_destroy}
			</div>
		</li>
	{/foreach}
</ul>

{/if}

{form _class="form" _novalidate="novalidate"}
	{render partial="shared/form_error"}

	{if $delivery_point_selected}
		{render partial="invoice_data"}

		{render partial="delivery_address"}
		{*render partial="billing_and_delivery_data_form__delivery_point_selected"*}
	{else}
		{render partial="delivery_address"}
		
		<div class="form__body">
			{render partial="shared/form_field" fields="fill_in_invoice_address"}
		</div>

		{render partial="invoice_data"}
	{/if}

	<div class="form__footer">
		{a action="checkouts/set_payment_and_delivery_method" _class="btn btn-lg btn-secondary btn--back btn--arrow-l"}{t}Zpět na dopravu a platbu{/t}{/a}
		{render partial="shared/form_button" class="btn btn-primary btn-lg"}
	</div>
{/form}
