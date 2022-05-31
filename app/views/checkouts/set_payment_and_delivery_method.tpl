{render partial="shared/checkout_navigation"}

<div class="basket-edit-header-wrapper">
	{render partial="shared/layout/content_header" title=$page_title}
	{render partial="regions/set_region_form" form=$set_region_form}
</div>

{form _class="form" _novalidate="novalidate"}
	{render partial="shared/form_error"}

	<div class="form__body">
		<div class="row">
			<div class="col-12 col-md-6">
				{render partial="shared/form_field" fields="delivery_method_id"}
			</div>
			<div class="col-12 col-md-6">
				{render partial="shared/form_field" fields="payment_method_id"}
			</div>
		</div>
	</div>

	<div class="form__footer">
		{a action="baskets/edit" _class="btn btn-lg btn-secondary btn--back btn--arrow-l"}{t}Back to basket content{/t}{/a}
		{render partial="shared/form_button" class="btn btn-primary btn-lg"}
	</div>
{/form}

