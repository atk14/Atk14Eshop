{**
 * Inicializace obsluhy vyberu pobocky pro GLS.
 *}
$("#ppl-parcelshop-map").PPL( {
	target_input_id: "id_delivery_service_branch_id",
	countries: {!$basket->getDeliveryCountriesAllowed()|to_json},
	language: {jstring}{$lang}{/jstring}
} );

