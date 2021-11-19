{**
	* Input 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme ho vubec odeslat ani pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize, ktery je po odeslani na serveru validovan.
	*}

{assign delivery_service $delivery_method->getDeliveryService()}

{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
	{render partial="widget_html_zasilkovna"}
{elseif $delivery_service && $delivery_service->getCode()=="gls"}
	{render partial="widget_html_gls"}
{elseif $delivery_service && $delivery_service->getCode()=="cp-balikovna"}
	{render partial="widget_html_cp_balikovna"}
{else}
	{render partial="shared/form_field" field=$branch_selector_form->get_field("delivery_service_widget")}
	{render partial="shared/form"}
{/if}

<script>
document.addEventListener( "DOMContentLoaded", function() {
{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
	{render partial="widget_js_zasilkovna"}
{/if}

{if $delivery_service && $delivery_service->getCode()=="gls"}
	{render partial="widget_js_gls"}
{/if}

{if $delivery_service && $delivery_service->getCode()=="cp-balikovna"}
	{render partial="widget_js_cp_balikovna"}
{/if}
} );
</script>
