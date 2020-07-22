/* global Packeta */

/**
 * Inicializace widgetu pro Zasilkovnu na zvolenem html elementu.
 *
 * Usage:
 *
 * $("#atk14-widget-zasilkovna").Zasilkovna( { target_input_id: "id_delivery_service_branch_id" })
 *
 */
( function( window, undefined ) {
	var $ = window.jQuery;

			// window.bootbox.hideAll();

	$.fn.extend( {
		Zasilkovna: function( options ) {

			options = options || { };
			var defaultOptions = {
				target_element_id: null
			};

			var apiKey = this.data( "api_key" );
			var zasilkovnaDiv = this;
			var targetElement = window.document.getElementById( options.target_input_id );

			if ( targetElement === null ) {
				console.log( "no target input set" );
			}

			$.getScript( "https://widget.packeta.com/www/js/library.js" )
			.done( function( script ) {
				console.log( "loading Zasilkovna library finished" );

				if ( zasilkovnaDiv ) {
					$( targetElement.form ).hide();

					Packeta.Widget.pick(
						apiKey,
						function( point ) {
							if ( point ) {
								this.value = point.id;
								targetElement.value = point.id;
								targetElement.form.submit();
							}
						},
						{
							country: "cz", language: "cs"
						},
						zasilkovnaDiv[ 0 ]
					);
				}
			} )
			.fail( function() {
				console.log( "loading Zasilkovna failed" );
			});
		}
	}
	);

} )( this );
