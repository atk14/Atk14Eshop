{**
	* 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme odeslat ihned pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize.
	*}

{if $delivery_method->getCode()=="zasilkovna"}
	<div id="atk14-widget-zasilkovna" data-api_key="b619aac6feafc06c"></div>
{else}
{render partial="shared/form_field" field=$branch_selector_form->get_field("delivery_service_widget")}
{/if}

{render partial="shared/form"}

<script>
{literal}
document.addEventListener( "DOMContentLoaded", function() {
	$("#atk14-widget-zasilkovna").Zasilkovna( { target_input_id: "id_delivery_service_branch_id" });
} );
{/literal}
</script>

