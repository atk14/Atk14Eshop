{assign currency $basket->getCurrency()}
{assign user $basket->getUser()}

{render partial="shared/checkout_navigation"}

<h1>{$page_title}</h1>

{form}
	{render partial="shared/form_error" small_form=false}
	<div class="form__body">
		{render partial="shared/order_detail" order=$basket}
		{render partial="shared/form_field" field="note"}
	</div>
	<div class="form__footer">
		{a action="checkouts/set_billing_and_delivery_data" _class="btn btn-lg btn-primary btn--back btn--arrow-l"}{t}Zpět na dodací údaje{/t}{/a}
		<div class="form__confirmation">
			{render partial="shared/form_field" field="gdpr"}

			{render partial="shared/form_field" field="confirmation"}
			{t url='obchodni-podminky'|link_to_page escape=no}Kliknutím na tlačítko Dokončit objednávku souhlasíte<br>a&nbsp;potvrzujete, že&nbsp;jste se seznámil s&nbsp;<a href="%1" target="_blank">obchodními&nbsp;podmínkami.</a>{/t}
		</div>
		{render partial="shared/form_button" class="btn btn-lg btn--cta"}
	</div>
{/form}
