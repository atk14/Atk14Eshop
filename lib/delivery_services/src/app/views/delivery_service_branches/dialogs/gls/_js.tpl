{**
 * Inicializace obsluhy vyberu pobocky pro GLS.
 *}
$("#atk14-widget-gls").GLS( {
	target_input_id: "id_delivery_service_branch_id",
	countries: {!$basket->getDeliveryCountriesAllowed()|to_json},
	language: {jstring}{$lang}{/jstring}
} );
