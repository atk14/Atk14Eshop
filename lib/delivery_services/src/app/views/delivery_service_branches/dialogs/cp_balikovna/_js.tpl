{**
 * Inicializace obsluhy vyberu pobocky pro Balikovnu ČP
 *}
$("#atk14-widget-cp-balikovna").CzechPost( {
	target_input_id: "id_delivery_service_branch_id",
	countries: {!$basket->getDeliveryCountriesAllowed()|to_json},
	language: {jstring}{$lang}{/jstring}
});
