{assign incl_vat !$basket->displayPricesWithoutVat()}

<div id="js--edit_form_content">

	{render partial="error_messages"}

	{render partial="add_more_to_get_free_delivery_message"}

	<div class="form__body">
		<table class="table-products table-products--main">
			<thead>
				<tr>
					<th class="table-products__image"><span class="sr-only">{t}Obrázek{/t}</span></th>
					<th class="table-products__title">{t}Produkt{/t}<span class="d-block d-lg-none">{t}Kód{/t}</span></th>
					<th class="table-products__id"><span class="d-none d-lg-inline">{t}Kód{/t}</span></th>
					<th class="table-products__unit-price">{if $incl_vat}{t}Jedn. cena{/t}{else}{t}Jedn. cena bez DPH{/t}{/if}</th>
					{if !$incl_vat}
					<th class="table-products__vat-percent">{t escape=no}%&nbsp;DPH{/t}</th>
					{/if}
					<th class="table-products__amount">{t}Množství{/t}</th>
					<th class="table-products__price">{if $incl_vat}{t}Celkem{/t}{else}{t}Celkem bez DPH{/t}{/if}</th>
					<th class="table-products__actions"><span class="sr-only">Actions</span></th>
				</tr>
			</thead>

			{render partial="items"}
			{render partial="discounts"}
			{render partial="footer"}
		</table>
	</div>

</div>
