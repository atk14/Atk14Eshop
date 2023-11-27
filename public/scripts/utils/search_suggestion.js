window.UTILS = window.UTILS || { };

/**
 * Provide search suggestion on an input field with the given class
 *
 * A suggesting area (e.g. <div> element, by default invisible) is required in the DOM.
 * Content for the suggesting  area is downloaded from the search form URL
 * with the parameter format=snippet.
 *
 * 	window.UTILS.searchSuggestion( "js--search-input", "js--suggesting-area" );
 * 	window.UTILS.searchSuggestion( "js--search-input", "js--suggesting-area", { hiding_suggesting_area: false } );
 *
 * Links in the snippet should have tabindex="10".
 */
window.UTILS.searchSuggestion = function( fieldClassName, suggestingAreaClassName, options ) {
	var stateIndex = fieldClassName;
	var $suggestingArea = $( "." + suggestingAreaClassName );
	var $field = $( "." + fieldClassName );
	var $submitBtn  = $field.siblings( "button[type='submit']" );

	options = $.extend( { hiding_suggesting_area: true }, options || {} );
	// console.log( fieldClassName );
	// console.log( options );

	if ( $suggestingArea.length === 0 ) {
		console.log(
			"searchSuggestion: Warning! No suggesting area found with class " +
			suggestingAreaClassName
		);
		return;
	}

	window.UTILS._search_suggestion.states[ stateIndex ] = {
		fieldClassName: fieldClassName,
		suggestingAreaClassName: suggestingAreaClassName,
		suggestingArea: $suggestingArea,
		field: $field,
		currentSearchField: null,
		submitBtn: $submitBtn,
		options: options,

		suggestingAreaVisible: false,
		suggestingCache: {},
		suggestingAreaNeedsToBePositioned: true,
		suggestingAreaOriginalContent: $suggestingArea.html()
	};

	//$suggestingArea.hide();
	window.UTILS._search_suggestion.hideSuggestingArea( stateIndex );

	$field.on( "keyup focus", function() {
		window.UTILS._search_suggestion.suggest( $( this ), $suggestingArea, stateIndex );
	} );

	if ( !window.UTILS._search_suggestion.initialized ) {

		window.UTILS._search_suggestion.initialize();
		window.UTILS._search_suggestion.initialized = true;

	}
};

/**
 * Here are the private things for the searchSuggestion plugin
 */
window.UTILS._search_suggestion = {

	inialized: false,

	states: {},

	suggest: function( $field, $suggestingArea, stateIndex ) {
		var $form = $field.closest( "form" );
		var url = $form.attr( "action" );
		var search = $field.val();
		var fieldName = $field.attr( "name" );
		var data = {};

		//if ( window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaOriginalContent === undefined ) {
		//	window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaOriginalContent =
		//		$suggestingArea.html();
		//}

		var searchFn = function( search ) {
			if ( search === "" ) {
				$suggestingArea.html(
					window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaOriginalContent
				);
				return;
			}

			if ( window.UTILS._search_suggestion.states[ stateIndex ].suggestingCache[ search ] ) {
				$suggestingArea.html( window.UTILS._search_suggestion.states[ stateIndex ].suggestingCache[ search ] );

				// Logging
				// console.log( "replaced from cache" );
				return;
			}

			if ( $suggestingArea.data( "suggesting" ) === "yes" ) {
				return;
			}

			$suggestingArea.data( "suggesting", "yes" );

			data.format = "snippet";
			data[ fieldName ] = search;
			$.ajax( {
				dataType: "html",
				url: url,
				data: data,
				success: function( snippet ) {
					$suggestingArea.data( "suggesting", "" );

					window.UTILS._search_suggestion.states[ stateIndex ].suggestingCache[ search ] = snippet;

					// It is expected that result for just one character is super fast
					if (
						search === $suggestingArea.data( "suggesting-for" ) ||
						search.length === 1
					) {
						$suggestingArea.html( snippet );

						// Logging
						// console.log( "content replaced" );
					}

					if ( search !== $suggestingArea.data( "suggesting-for" ) ) {
						searchFn( $suggestingArea.data( "suggesting-for" ) );
					}
				}
			} );
		};

		search = search.trim();

		if ( search === $suggestingArea.data( "suggesting-for" ) ) {
			return;
		}

		// Search for the first character to improve responsivity
		if ( search.length > 1 && !$suggestingArea.data( "suggesting-for" ) ) {
			$suggestingArea.data( "suggesting-for", search.substr( 0, 1 ) );
			searchFn( search.substr( 0, 1 ) );
		}

		$suggestingArea.data( "suggesting-for", search );
		searchFn( search );
	},

	positionSuggestingArea: function( searchField, suggArea, stateIndex ) {

		// In the mobile layout the search input changes its location
		//if ( !window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaNeedsToBePositioned ) {
		//	return;
		//}

		var fieldOffset = searchField.offset();
		suggArea.css( "top", fieldOffset.top + searchField.outerHeight() + 2 + "px" );

		// Get x position of search field right edge plus button width
		var searchBtnWidth = searchField.siblings( "button" ).outerWidth();
		var rightPos = fieldOffset.left + searchField.outerWidth() + searchBtnWidth;

		// Align suggestions to rightPos if there is enough room, center otherwise
		if ( rightPos > suggArea.width() ) {
			suggArea.css( "left", rightPos - suggArea.width() + "px" );
		} else {
			suggArea.css( "left", ( document.body.clientWidth - suggArea.width() ) / 2 );
		}

		// Logging
		// console.log( "re-positioned" );
		// console.log( searchField );
		// console.log( fieldOffset , rightPos );

		window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaNeedsToBePositioned = false;
	},

	initialize: function() {
		$( "body" ).on( "click keyup", function( e ) {
			var $activeElement = $( e.target );
			Object.keys( window.UTILS._search_suggestion.states ).forEach( function( stateIndex ) {
				var state = window.UTILS._search_suggestion.states[ stateIndex ];
				var fieldClassName = state.fieldClassName;
				var $currentSearchField = state.currentSearchField;
				var suggestingAreaClassName = state.suggestingAreaClassName;
				var $suggestingArea = state.suggestingArea;
				var $field = state.field;
				var $submitBtn = state.submitBtn;

				var searchFieldIsActiveAndEmpty =
					$activeElement.hasClass( fieldClassName ) &&
					$activeElement.val().length === 0;

				if ( $activeElement.hasClass( fieldClassName ) ) {
					$currentSearchField = $activeElement;
					state.currentSearchField = $currentSearchField;
				}

				if (
					!$currentSearchField ||
					!$currentSearchField.is( ":visible" ) ||
					searchFieldIsActiveAndEmpty || (
						!$activeElement.hasClass( fieldClassName ) &&
						!$activeElement.hasClass( suggestingAreaClassName ) &&
						$activeElement.closest( "." + suggestingAreaClassName ).length === 0
					)
				) {

					// Event outside suggestion area or search field: Hide suggestion area if visible
					if ( window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaVisible ) {
						window.UTILS._search_suggestion.hideSuggestingArea( stateIndex );
						window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaVisible = false;

						// Restore tabindex for search form elements to 0
						$field.attr( "tabindex", 0 );
						$submitBtn.attr( "tabindex", 0);

						// Logging
						// console.log( stateIndex + ": fadeOut (1)" );
					}
				} else {

					// Event inside search field or sugg. area
					if ( $activeElement.hasClass( fieldClassName ) ) {

						// Event inside search field
						window.UTILS._search_suggestion.positionSuggestingArea(
							$activeElement,
							$suggestingArea,
							stateIndex
						);
					}
					if ( !window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaVisible ) {

						// Show suggestions if hidden
						window.UTILS._search_suggestion.showSuggestingArea( stateIndex );
						window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaVisible = true;

						// Set temporary tabindex for search form elements
						$field.attr( "tabindex", 10 );
						$submitBtn.attr( "tabindex", 11);

						// Logging
						// console.log( stateIndex + ": fadeIn (1)" );
					}
				}
			} );
		} );

		$( "body" ).on( "touchstart", function( e ) {
			Object.keys( window.UTILS._search_suggestion.states ).forEach( function( stateIndex ) {
				var state = window.UTILS._search_suggestion.states[ stateIndex ];
				var $currentSearchField = state.currentSearchField;
				var fieldClassName = state.fieldClassName;

				if (
					$currentSearchField &&
					$currentSearchField.is( ":focus" ) &&
					!$( e.target ).hasClass( fieldClassName ) // Clicked on the field itself?
				) {
					$currentSearchField.blur();
				}
			} );
		} );

		$( window ).on( "resize", function() {
			Object.keys( window.UTILS._search_suggestion.states ).forEach( function( stateIndex ) {
				var state = window.UTILS._search_suggestion.states[ stateIndex ];
				var $currentSearchField = state.currentSearchField;
				var $suggestingArea = state.suggestingArea;

				window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaNeedsToBePositioned = true;

				// Hide suggestions if corresponding searchfield is not visible anymore
				// Warning: we are checking offset top value to be greater than zero
				// if searchfiled would be positioned on top of the screen there would be problem
				if ( $currentSearchField ) {
					if (	$currentSearchField.css( "display" ) === "none" ||
						$currentSearchField.offset().top < 1 ) {
						window.UTILS._search_suggestion.hideSuggestingArea( stateIndex );
						window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaVisible = false;
					}
				}

				if ( window.UTILS._search_suggestion.states[ stateIndex ].suggestingAreaVisible ) {

					// We need to delay a bit to wait for  possible transformations on the page
					setTimeout(
						window.UTILS._search_suggestion.positionSuggestingArea(
							$currentSearchField,
							$suggestingArea,
							stateIndex
						),
						5000
					);
				}
			} );
		} );
	},

	showSuggestingArea: function( stateIndex ) {
		var options = window.UTILS._search_suggestion.states[ stateIndex ].options;
		var $suggestingArea = window.UTILS._search_suggestion.states[ stateIndex ].suggestingArea;
		if ( options.hiding_suggesting_area ) {
			$suggestingArea.fadeIn();
		}
	},

	hideSuggestingArea: function( stateIndex ) {
		var options = window.UTILS._search_suggestion.states[ stateIndex ].options;
		var $suggestingArea = window.UTILS._search_suggestion.states[ stateIndex ].suggestingArea;
		if ( options.hiding_suggesting_area ) {
			$suggestingArea.fadeOut();
		}
	}
};
