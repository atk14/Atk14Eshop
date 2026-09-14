{**
	* Input 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme ho vubec odeslat ani pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize, ktery je po odeslani na serveru validovan.
	*}


{if $dialog_provider != "default"}
<div id="delivery_service_branch_widget_loading" class="preloader">
	<div class="spinner-border text-secondary" role="status">
		<span class="sr-only">{t}Loading...{/t}</span>
	</div>
	<div>{t}Načítání...{/t}</div>
</div>
{/if}

{render partial="$widget_template_html"}

{javascript_tag}
document.addEventListener( "DOMContentLoaded", function() {
	{render partial="$widget_template_js"}
} );
{/javascript_tag}
