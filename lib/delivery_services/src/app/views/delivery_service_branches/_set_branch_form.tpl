{**
	* Input 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme ho vubec odeslat ani pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize, ktery je po odeslani na serveru validovan.
	*}

{assign delivery_service $delivery_method->getDeliveryService()}

{if $delivery_service}
	{render partial="shared/form_error"}
	{render partial="$widget_template_html"}
{else}
	{render partial="shared/form_field" field=$branch_selector_form->get_field("delivery_service_widget")}
	{render partial="shared/form"}
{/if}

<script>
document.addEventListener( "DOMContentLoaded", function() {
{if $delivery_service}
	{render partial="$widget_template_js"}
{/if}
} );
</script>
