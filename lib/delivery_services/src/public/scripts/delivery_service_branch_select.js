// Zajisti vyber dorucovaci posty ve vyberu dopravy a platby
( function( window ) {
	"use strict";

	var $ = window.jQuery;

	window.UTILS = window.UTILS || { };

	var selectorBranchNeededField = "input[data-branch_needed='1'][name='delivery_method_id']";

	window.UTILS.deliveryServiceBranchSelector = {
		setAutocomplete: function( element, options ) {
			var defaultOptions = {

				// Id inputu, do ktereho se bude ukladat vybrana pobocka, a pak se bude validovat
				target_element_id: null
			};
			options = $.extend( defaultOptions, options );

			var targetElement = null;
			if ( options.target_element_id && $( options.target_element_id ) ) {
				targetElement = $( options.target_element_id );
			}

			// Toto je tu pro pripad, ze by uzivatel odeslal formular pomoci buttonu.
			// V takovem pripade chceme prevzit hodnotu z naseptavadla,
			// odeslat ji s formularem a zvalidovat
			targetElement.parents( "form" ).on( "submit", function() {

				if ( $( element ).val() !== undefined ) {

					// Toto chceme pouzit jen kdyz pouzivame input field s naseptavanim.
					// pri pouziti widgetu, treba s mapou
					// @todo zajistit, aby toto probihalo jen ve formulari s widgetem
					targetElement.val( $( element ).val() );
				}
			} );

			$( document ).on( "autocompleteselect", element, function( event, ui ) {
				var targetElement = $( event.target );

				if ( options.target_element_id && $( options.target_element_id ) ) {
					targetElement = $( options.target_element_id );
				}
				targetElement.val( ui.item.value );

				// Po zvoleni polozky ze seznamu zavolame submit formulare
				// setTimeout je hack, kvuli nejakemu problemu v jquery autocomplete,
				// ktery zpusobi rozdilne chovani pri vyberu polozky klavesnici a mysi
				setTimeout( function() {
					targetElement.parents( "form" ).submit();
				}, 1 );
			} )
			.on( "autocompleteopen", element, function( ) {
				$( "[data-toggle=tooltip]" ).tooltip();
			} )
			.on( "autocompletecreate", element, function( ) {
				var acInstance = $( element ).autocomplete( "instance" );

				if ( acInstance ) {
					acInstance._renderItem = function( ul, item ) {
						return window.UTILS.deliveryServiceBranchSelector._renderItem( ul, item );
					};
				}
			} );
		},

		_renderItem: function( ul, item ) {
			var openingHoursDay = "";
			var openingHoursHours = "";
			var openingHours = $( "<div>" ).addClass( "opening_hours_wrapper" );
			var openingHoursWrap = $( "<div>" );

			$.each( JSON.parse( item.opening_hours ), function( i, day ) {

				var hoursAr = [];
				$.each( day.hours, function( i, hour ) {
					hoursAr.push( hour.open_from + " - " + hour.open_to );
				} );

				if ( hoursAr.length === 0 ) {
					return;
				}
				openingHoursDay = $( "<em>" ).html( day.day_name + ":" );
				openingHoursHours = $( "<span>" ).append( hoursAr.join( ", " ) );

				var openingHoursRow = $( "<div>" )
					.append( openingHoursDay )
					.append( "&nbsp;" )
					.append( openingHoursHours );

				openingHours.append( openingHoursRow );
			} );

			openingHoursWrap.append( openingHours );

			var openingHoursElement = $( "<a>", {
				href: "#",
				title: openingHoursWrap.html(),
				"data-html": true,
				"data-toggle": "tooltip"
			}	).addClass( "far fa-clock" );

			var inner = $( "<div>" )
				.append( $( "<div>" + item.label + "</div>" ) )
				.append( openingHoursElement );

			var out = $( "<li>" )
				.append( inner )
				.appendTo( ul );
			return out;
		},

		init: function() {

			this.setAutocomplete( "#id_delivery_service_widget", {
				target_element_id: "#id_delivery_service_branch_id"
			} );
		},

		/* Vyvola click na odkaz pro vyber pobocky
		 * po aktivaci radio buttonu
		 *
		 * @todo mozna by se dalo rovnou otevrit patricny dialog
		 */
		performClickOnRadioCheck: function() {
			if ( $( this ).is( ":checked" ) ) {
				$( this ).parents( "li" )
					.find( ".delivery_service_branch .branch_button > a" )
					.trigger( "click" );
			}
		}
	};

	// Po zvoleni dorucovaci sluzby s vyberem vydejniho mista
	// Zasilkovna, nektere sluzby Ceske Posty, ci jine
	// chceme otevrit dialog s vyberem pobocky
	// proto vyvolame event 'click' na odkaz pro zmenu pobocky
	$( "#form_checkouts_set_payment_and_delivery_method" + " " + selectorBranchNeededField )
		.unbind( "change.delivery" )
		.bind( "change.delivery",
			window.UTILS.deliveryServiceBranchSelector.performClickOnRadioCheck );

	window.UTILS.deliveryServiceBranchSelector.init();

} )( this );

