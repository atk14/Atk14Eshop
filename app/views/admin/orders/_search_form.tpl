{*
 * Render a search form
 *
 * It is expected that the form contains just a single field: search
 *}

{if empty($button_text) && $form}
	{assign var=button_text value=$form->get_button_text()}
{/if}

{form _class="form-search"}
	<div class="row">
		<div class="col-md-3">
	{!$form.search}
		</div>
		<div class="col-md-3">
	{!$form.catalog_id}
		</div>
		<div class="col-md-3">
	{!$form.date_from}
		</div>
		<div class="col-md-3">
	{!$form.date_to}
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
	{!$form.delivery_method_id}
		</div>
		<div class="col-md-3">
	{!$form.payment_method_id}
		</div>
		<div class="col-md-3">
	{!$form.payment_status_id}
		</div>
		<div class="col-md-3">
	{!$form.order_status_id}
		</div>
	</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-9">
				<button type="submit" class="btn">{$button_text}</button>
			</div>
		</div>
{/form}
