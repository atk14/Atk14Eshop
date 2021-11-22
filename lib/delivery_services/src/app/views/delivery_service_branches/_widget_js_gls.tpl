{**
 * Inicializace obsluhy vyberu pobocky pro GLS.
 *}
{literal}
	$("#atk14-widget-gls").GLS( {
		target_input_id: "id_delivery_service_branch_id",
{/literal}
		countries: {!$basket->getDeliveryCountriesAllowed()|to_json},
		language: {jstring}{$lang}{/jstring}
{literal}
	});
{/literal}
