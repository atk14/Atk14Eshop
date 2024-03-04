{if !$delivery_address_editable_by_user}

<div class="form__body">
	<h3 class="form__legend">{t}Kontaktní údaje pro vyzvednutí zásilky{/t}</h3>
	{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,email,delivery_phone"}
</div>

<div class="form__body">
	<h3 class="form__legend">
		{if $basket->personalPickupOnStoreSelected()}
			{t}Adresa pro osobní převzetí{/t}
		{else}
			{t}Adresa výdejního místa{/t}
		{/if}
	</h3>
	{* tady chybi delivery_address_note - je to disablovane policko a je matouci *}
	{render partial="shared/form_field" fields="delivery_company,delivery_address_street,delivery_address_city"}
	{if ALLOW_STATE_IN_ADDRESS}
		{render partial="shared/form_field" fields="delivery_address_state"}
	{/if}
	{render partial="shared/form_field" fields="delivery_address_zip,delivery_address_country"}
</div>

{else}

<div class="form__body">
	<h3 class="form__legend">{t}Adresa pro doručení{/t}</h3>
	{render partial="shared/form_field" fields="delivery_firstname,delivery_lastname,email,delivery_phone,delivery_company,delivery_address_street,delivery_address_city"}
	{if ALLOW_STATE_IN_ADDRESS}
		{render partial="shared/form_field" fields="delivery_address_state"}
	{/if}
	{render partial="shared/form_field" fields="delivery_address_zip,delivery_address_country,delivery_address_note"}
</div>

{/if}
