{**
	* Input 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme ho vubec odeslat ani pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize, ktery je po odeslani na serveru validovan.
	*}


{render partial="shared/form_error"}
{render partial="$widget_template_html"}

<script>
document.addEventListener( "DOMContentLoaded", function() {
	{render partial="$widget_template_js"}
} );
</script>
