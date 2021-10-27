{**
	* Input 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme ho vubec odeslat ani pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize, ktery je po odeslani na serveru validovan.
	*}

{assign delivery_service $delivery_method->getDeliveryService()}

{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
	<div id="atk14-widget-zasilkovna" data-api_key="{"delivery_services.zasilkovna.api_key"|system_parameter}"></div>
{elseif $delivery_service && $delivery_service->getCode()=="gls"}
	<iframe id="atk14-widget-gls" src="https://maps.gls-czech.cz/?tdetail=3&lng=cs"></iframe>
	<div class="container-fluid branch-detail">

	<div id="atk14-widget-branch" class="row">
		<div class="col-12 col-sm-6 branch-text">
			<div>
				<div class="branch-name"></div>
				<div class="branch-address"></div>
			</div>
			{render partial="shared/form"}
		</div>
		<div class="col-12 col-sm-6 text-sm-right">
			<img class="branch-image">
		</div>
	</div>
{else}
	{render partial="shared/form_field" field=$branch_selector_form->get_field("delivery_service_widget")}
	{render partial="shared/form"}
{/if}

{*render partial="shared/form"*}

	
</div>
{**
 * Inicializace obsluhy vyberu pobocky pro Zasilkovnu.
 *}
{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
<script>
{literal}
document.addEventListener( "DOMContentLoaded", function() {
	$("#atk14-widget-zasilkovna").Zasilkovna( { target_input_id: "id_delivery_service_branch_id" });
} );
{/literal}
</script>
{/if}

{**
 * Inicializace obsluhy vyberu pobocky pro GLS.
 *}
{if $delivery_service && $delivery_service->getCode()=="gls"}
<script>
{literal}
document.addEventListener( "DOMContentLoaded", function() {
	$("#atk14-widget-gls").GLS( {
		target_input_id: "id_delivery_service_branch_id",
{/literal}
		countries: {!$basket->getDeliveryCountriesAllowed()|to_json},
		language: {jstring}{$lang}{/jstring}
{literal}
	});
} );
{/literal}
</script>
{/if}

