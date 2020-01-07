<div class="col--catfilters">
	{if $form->fields}
		<h3 class="text--fancy text-primary">{t}Filtr{/t}</h4>
		<div id="filter">
			{form_remote}
				<fieldset>
					<div id="filter_fields">
						{render partial="shared/form_field" fields=$form->get_field_keys()}
					</div>
					{render partial="shared/form_button" class="btn btn-default js-hide"}
				</fieldset>
			{/form_remote}
		</div>
	{/if}
</div>
