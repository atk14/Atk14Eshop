{if $request->get()}

	$("#watchdog_modal_dialog").remove();
	$(".modal-backdrop").remove();

	var $modal = $({jstring}{modal id=watchdog_modal_dialog title=$page_title}
		{render partial="shared/form_remote"}
	{/modal}{/jstring});

	$modal.appendTo("body");

	$("#watchdog_modal_dialog").modal("show");

{elseif $form->has_errors()}

	$form.replaceWith( {jstring}{render partial="shared/form_remote"}{/jstring} );

{else}

	{* successfully saved *}

	$form.replaceWith( {jstring}
		<center>
			<span class="h1 text-success"><br>{!"check"|icon} {t}Successfully saved{/t}<br><br></span>
		</center>
	{/jstring} );

	setTimeout(function(){ $("#watchdog_modal_dialog").modal("hide"); }, 1000);

{/if}
