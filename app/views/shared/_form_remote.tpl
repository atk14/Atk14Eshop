{*
 * Renders a remote form in generic way
 *
 * Usefull for scaffolding
 *
 * {render partial="shared/form_remote"}
 * {render partial="shared/form_remote" form=$search_form}
 * {render partial="shared/form_remote" form=$search_form button_text="Search"}
 * {render partial="shared/form_remote" form=$search_form button_text="Search" small_form=1}
 * {render partial="shared/form_remote" form=$search_form button_text="Search" button_class="search"}
 *
 * {render partial="shared/form_remote" form_class="search"}
 *}

{if !isset($small_form)}
	{assign var=small_form value=$form->is_small()}
{/if}

{if !$small_form}
	{assign var="form_layout" value="form-horizontal"}
{/if}

{assign field_keys $form->get_field_keys()}
{if $enabled_fields_only}
	{assign field_keys $form->get_enabled_field_keys()}
{/if}

{capture assign=class}{trim}{$form_class} {$form_layout}{/trim}{/capture}
{capture assign=class}{trim}{$class} {$form->get_attr("class")}{/trim}{/capture}

{form_remote _novalidate="novalidate" _class=$class _role="form"}
	{render partial="shared/form_error"}
	<fieldset>
		{render partial="shared/form_field" fields=$field_keys}
		{render partial="shared/form_button" class=$button_class}
	</fieldset>
{/form_remote}
