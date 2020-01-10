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
			{!$form|field:"search":"label_to_placeholder"}
		</div>
		<div class="col-md-3">
			{!$form|field:"catalog_id":"label_to_placeholder"}
		</div>
		<div class="col-md-3">
			{!$form|field:"date_from":"label_to_placeholder"}
		</div>
		<div class="col-md-3">
			{!$form|field:"date_to":"label_to_placeholder"}
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			{!$form|field:"delivery_method_id":"label_to_placeholder"}
		</div>
		<div class="col-md-3">
			{!$form|field:"payment_method_id":"label_to_placeholder"}
		</div>
		<div class="col-md-3">
			{!$form|field:"payment_status_id":"label_to_placeholder"}
		</div>
		<div class="col-md-3">
			{!$form|field:"order_status":"label_to_placeholder"}
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-md-offset-9">
			<button type="submit" class="btn btn-secondary">{$button_text}</button>
		</div>
	</div>
{/form}
