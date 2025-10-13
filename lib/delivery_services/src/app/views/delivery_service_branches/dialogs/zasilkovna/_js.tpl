{**
 * Inicializace obsluhy vyberu pobocky pro Zasilkovnu.
 *}
$("#atk14-widget-zasilkovna").Zasilkovna( {
	target_input_id: "id_delivery_service_branch_id",
	countries: {!$basket->getDeliveryCountriesAllowed()|to_json},
	language: "{$lang}"
} );
