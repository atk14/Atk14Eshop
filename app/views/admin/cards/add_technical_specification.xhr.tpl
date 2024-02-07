{if $form->has_errors()}

	$form.replaceWith({jstring}{render partial="add_technical_specification_form"}{/jstring});
	
{else}

	$("#technical_specifications").replaceWith({jstring}{render partial="technical_specifications" add_technical_specification_form=$form}{/jstring});

	ADMIN.utils.handleSortables();
	window.UTILS.AdminSuggestions.handleSuggestions();

{/if}

// there can be one or two text input fields in the form
$("#technical_specifications").find("input[type=text]").first().focus();
