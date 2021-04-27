/* global Packeta */

/**
 * Inicializace widgetu pro Zasilkovnu na zvolenem html elementu.
 *
 * Usage:
 *
 * $("#atk14-widget-zasilkovna").Zasilkovna( {
 *    target_input_id: "id_delivery_service_branch_id",
 *    countries: [ "CZ", "SK" ],
 *    language: "en"
 * } );
 *
 */
( function( window ) {
	var $ = window.jQuery;

	$.fn.extend( {
		Zasilkovna: function( options ) {

			options = options || { };
			var defaultOptions = {
				target_element_id: null,
				countries: [ "CZ" ], // [ "CZ", "SK" ]
				language: "cs"
			};

			options = $.extend( defaultOptions, options );

			var apiKey = this.data( "api_key" );
			var zasilkovnaDiv = this;
			var targetElement = window.document.getElementById( options.target_input_id );
			var country = options.countries.join( "," ).toLowerCase();

			if ( targetElement === null ) {
				console.warn( "no target input set" );
			}

			if ( zasilkovnaDiv.length === 0) {
				console.warn( "no element usable for Zasilkovna widget" );
				return false;
			}

			$.getScript( "https://widget.packeta.com/www/js/library.js" )
			.done( function() {
				console.log( "loading Zasilkovna library finished" );

					$( targetElement.form ).hide();

					Packeta.Widget.pick(
						apiKey,
						function( point ) {
							if ( point ) {
								this.value = point.id;
								targetElement.value = point.id;
								targetElement.form.submit();
							}
							$("#delivery_service_branch_select").modal("hide");
						},
						{
							country: country, language: options.language
						},
						zasilkovnaDiv[ 0 ]
					);
			} )
			.fail( function() {
				console.log( "loading Zasilkovna failed" );
			} );
		}
	} );

} )( this );
