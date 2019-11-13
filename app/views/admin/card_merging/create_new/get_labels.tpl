<h1>{$page_title}</h1>

<p>{t}Doplňte k produktům krátké názvy pro rozlišení varianty.{/t}</p>

{form _class="form-horizontal" _novalidate=novalidate}

	{render partial="shared/form_error"}
	
	{foreach $fieldsets as $fieldset}
		<fieldset>
			<legend>{t name=$fieldset.card->getName() escape=no}Variants on product card <em>%1</em>{/t}</legend>
			{render partial="shared/form_field" fields=$fieldset.fields}
		</fieldset>
	{/foreach}

	<fieldset>
		{render partial="shared/form_button"}
	</fieldset>

{/form}
