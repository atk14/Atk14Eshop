{if $form->fields}
	{form_remote}
			<div class="js--filter_fields">
				{render partial='shared/form_field' field='f_category'}
			</div>
	{/form_remote}
{/if}
