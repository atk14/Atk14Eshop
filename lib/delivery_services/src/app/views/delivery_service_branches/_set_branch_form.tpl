{**
	* Input 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme ho vubec odeslat ani pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize, ktery je po odeslani na serveru validovan.
	*}

{assign delivery_service $delivery_method->getDeliveryService()}

{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
	<div id="atk14-widget-zasilkovna" data-api_key="{"delivery_services.zasilkovna.api_key"|system_parameter}"></div>
{else}
{render partial="shared/form_field" field=$branch_selector_form->get_field("delivery_service_widget")}
{/if}

{render partial="shared/form"}

{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
<script>
{literal}
document.addEventListener( "DOMContentLoaded", function() {
	$("#atk14-widget-zasilkovna").Zasilkovna( { target_input_id: "id_delivery_service_branch_id" });
} );
{/literal}
</script>
{/if}
