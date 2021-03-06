{*
 * Render a search form
 *
 * It is expected that the form contains just a single field: search
 *}

{if empty($button_text) && $form}
	{assign var=button_text value=$form->get_button_text()}
{/if}

{form _class="form-filter"}
	<div class="row">
		<div class="col-12 col-sm-6 col-md-3 input-group">
			{!$form|field:"search":"label_to_placeholder"}
		</div>
		<div class="col-12 col-sm-6 col-md-3">
			{!$form|field:"catalog_id":"label_to_placeholder"}
		</div>
		<div class="col-12 col-sm-6 col-md-3">
			{!$form|field:"date_from":"label_to_placeholder"}
		</div>
		<div class="col-12 col-sm-6 col-md-3">
			{!$form|field:"date_to":"label_to_placeholder"}
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-sm-6 col-md-3 input-group">
			{!$form|field:"delivery_method_id":"label_to_placeholder"}
		</div>
		<div class="col-12 col-sm-6 col-md-3">
			{!$form|field:"payment_method_id":"label_to_placeholder"}
		</div>
		<div class="col-12 col-sm-6 col-md-3">
			{!$form|field:"payment_status_id":"label_to_placeholder"}
		</div>
		<div class="col-12 col-sm-6 col-md-3">
			{!$form|field:"order_status":"label_to_placeholder"}
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<button type="submit" class="btn btn-secondary">{$button_text}</button>
			<button type="reset" class="btn btn-outline-secondary">{t}Zrušit filtry{/t}</button>
		</div>
	</div>
{/form}
