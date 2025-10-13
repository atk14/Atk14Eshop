<h1>{$page_title}</h1>

<p>
	{t}Zadejte číslo objednávky, ve které byl dárkový kupónu objednán.{/t}
</p>

{form _novalidate="novalidate"}
	{render partial="shared/form_error"}

	<fieldset>
	{render partial="shared/form_field" field="order"}
	<div class="form-group">
		<span class="button-container">
			<button type="submit" class="btn btn-primary">{t}Pokračovat{/t}</button>
			<button type="submit" name="skip" class="btn btn-warning">{t}Přeskočit - nespojovat kupón s objednávkou{/t}</button>
		</span>
	</div>
	</fieldset>
{/form}
