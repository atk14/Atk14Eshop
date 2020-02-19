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
					<th class="table-products__unit-price">{t}Jedn. cena{/t}</th>
					<th class="table-products__amount">{t}Množství{/t}</th>
					<th class="table-products__price">{t}Celkem{/t}</th>
					<th class="table-products__actions"><span class="sr-only">Actions</span></th>
				</tr>
			</thead>

			{render partial="items"}
			{render partial="discounts"}
			{render partial="footer"}
		</table>
	</div>

</div>
