window.UTILS = window.UTILS || { };

/**
 * Provide search suggestion on an input field with the given class
 *
 * A suggesting area (e.g. <div> element, by default invisible) is required in the DOM.
 * Content for the suggesting  area is downloaded from the search form URL
 * with the parameter format=snippet.
 *
 * 	window.UTILS.searchSuggestion( "js--search-input", "js--suggesting-area" );
 *
 */
window.UTILS.searchSuggestion = function( fieldClassName, suggestingAreaClassName ) {
	var $suggArea = $( "." + suggestingAreaClassName );
	var $field = $( "." + fieldClassName );
	var $currentSearchField;

	if ( $suggArea.length === 0 ) {
		console.log(
			"searchSuggestion: Warning! No suggesting area found with class " +
			suggestingAreaClassName
		);
		return;
	}

	$suggArea.hide();

	$field.on( "keyup focus", function( e ) {
		window.UTILS._search_suggestion.suggest( $( this ), $suggArea );
	} );

	$( "body" ).on( "click keyup", function( e ) {
		var $activeElement = $( e.target );
		var searchFieldIsActiveAndEmpty =
			$activeElement.hasClass( fieldClassName ) &&
			$activeElement.val().length === 0;

		if ( $activeElement.hasClass( fieldClassName ) ) {
			$currentSearchField = $activeElement;
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
			if ( window.UTILS._search_suggestion.suggestingAreaVisible ) {
				$suggArea.fadeOut();
				window.UTILS._search_suggestion.suggestingAreaVisible = false;

				// Logging
				// console.log( "fadeOut" );
			}
		} else {
			if ( $activeElement.hasClass( fieldClassName ) ) {
				window.UTILS._search_suggestion.positionSuggestingArea(
					$activeElement,
					$suggArea
				);
			}
			if ( !window.UTILS._search_suggestion.suggestingAreaVisible ) {
				$suggArea.fadeIn();
				window.UTILS._search_suggestion.suggestingAreaVisible = true;

				// Logging
				// console.log( "fadeIn" );
			}
		}
	} );

	$( window ).on( "resize", function() {
		window.UTILS._search_suggestion.suggestingAreaNeedsToBePositioned = true;

		// Hide suggestions if corresponding searchfield is not visible anymore
		// Warning: we are checking offset top value to be greater than zero
		// if searchfiled would be positioned on top of the screen there would be problem
		if ( $currentSearchField ) {
			if (	$currentSearchField.css( "display" ) === "none" ||
				$currentSearchField.offset().top < 1 ) {
				$suggArea.fadeOut();
				window.UTILS._search_suggestion.suggestingAreaVisible = false;
			}
		}

		if ( window.UTILS._search_suggestion.suggestingAreaVisible ) {

			// We need to delay a bit to wait for  possible transformations on the page
			setTimeout(
				window.UTILS._search_suggestion.positionSuggestingArea(
					$currentSearchField,
					$suggArea
				),
				5000
			);
		}
	} );
};

window.UTILS._search_suggestion = {

	suggestingAreaVisible: false,
	suggestingCache: {},
	suggestingAreaNeedsToBePositioned: true,
	suggestingAreaOriginalContent: undefined,

	suggest: function( $field, $suggestingArea ) {
		var $form = $field.closest( "form" );
		var url = $form.attr( "action" );
		var search = $field.val();
		var fieldName = $field.attr( "name" );
		var data = {};

		if ( window.UTILS._search_suggestion.suggestingAreaOriginalContent === undefined ) {
			window.UTILS._search_suggestion.suggestingAreaOriginalContent = $suggestingArea.html();
		}

		var searchFn = function( search ) {
			if ( search === "" ) {
				$suggestingArea.html(
					window.UTILS._search_suggestion.suggestingAreaOriginalContent
				);
				return;
			}

			if ( window.UTILS._search_suggestion.suggestingCache[ search ] ) {
				$suggestingArea.html( window.UTILS._search_suggestion.suggestingCache[ search ] );

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

					window.UTILS._search_suggestion.suggestingCache[ search ] = snippet;

					// It is expected that result for just one character is super fast
					if ( search === $suggestingArea.data( "suggesting-for" ) || search.length === 1 ) {
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
			$suggestingArea.data( "suggesting-for", search.substr( 0, 1) );
			searchFn( search.substr( 0, 1) );
		}

		$suggestingArea.data( "suggesting-for", search );
		searchFn( search );
	},

	positionSuggestingArea: function( searchField, suggArea ) {

		// In the mobile layout the search input changes its location
		//if ( !window.UTILS._search_suggestion.suggestingAreaNeedsToBePositioned ) {
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

		window.UTILS._search_suggestion.suggestingAreaNeedsToBePositioned = false;
	}
};
