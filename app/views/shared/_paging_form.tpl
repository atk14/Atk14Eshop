{if $paging_form}
{form _novalidate="novalidate" _class='cards_paging_form' form=$paging_form}

	{if sizeof($paging_form->fields.order->get_choices())>1}
	{* Yarri: Rikam si, ze nema cenu zobrazovat formular s raditkem, ktere ma jenom jednu volbu *}

	{render partial="shared/form_error" form=$paging_form}
	<div class="form__body">
		{render partial="shared/form_field" fields=order form=$paging_form}
		{*render partial="shared/form_field" fields=page_size form=$paging_form*}
	</div>

	<div class="form__footer nojs-only">
		{render partial="shared/form_button" class=$button_class form=$paging_form}
	</div>

	{/if}

{/form}
{/if}
