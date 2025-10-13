{form _novalidate="novalidate" _class="form-horizontal"}

	{render partial="shared/form_error"}

	<fieldset>
		{render partial="shared/form_field" fields="firstname,lastname,company,address_street,address_city"}
		{if ALLOW_STATE_IN_ADDRESS}
			{render partial="shared/form_field" fields="address_state"}
		{/if}
		{render partial="shared/form_field" fields="address_zip,address_country,phone,address_note"}
	</fieldset>

	<fieldset>
		{render partial="shared/form_button" class=$button_class}
	</fieldset>	

{/form}
