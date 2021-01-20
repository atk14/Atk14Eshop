/* global gtag */
/* global ga */

/**
 * Finds links to iobjects of type file and binds a function on click event.
 *
 * Called function sends a page_view event to Google Analytics if it is possible.
 * */
( function( $ ) {

	function hitCallback( event ) {
		var targetHref = event.currentTarget.href;
		if ( event.currentTarget.target === "_blank" ) {
			window.open( targetHref, "_blank" );
		} else {
			document.location = targetHref;
		}
	}

	function getGAtype() {
		var patterns = {
			ua: {
				re: /www\.google-analytics\.com\/analytics\.js/,
			},
			classic: {
				re: /www\.google-analytics\.com\/ga\.js/
			},
			gtag: {
				re: /www\.googletagmanager\.com\/gtag\/js/,
			}
		};

		var usedType = null;

		var srcAr = $( "script" ).map( function(idx, el) {
			return el.src ;
		} );

		srcAr.each( function( idx, el ) {
			if ( patterns.classic.re.test( el ) ) {
				usedType = "classic";
				return false;
			}
			if ( patterns.ua.re.test( el ) ) {
				usedType = "ua";
				return false;
			}
			if ( patterns.gtag.re.test( el ) ) {
				usedType = "gtag";
				return false;
			}
		} );
		return usedType;
	}

  function doClick( event ) {
		if ( detectedGAType === "gtag" ) {
			if ( ( typeof gtag !== "undefined" && typeof gtag === "function" ) === false) {
				return;
			}

			event.preventDefault();
			gtag( "event", "page_view", {
				page_location: event.currentTarget.href,
				event_callback: hitCallback( event ),
			} );
		} else if ( detectedGAType === "ua" ) {
			if ( ( typeof ga !== "undefined" && typeof ga === "function" ) === false) {
				return;
			}
			event.preventDefault();
			ga( "send", {
				hitType: "pageview",
				location: event.currentTarget.href,
				hitCallback: hitCallback( event ),
			} );
			console.log( "using universal analytics.js" );
		} else if ( detectedGAType === "classic" ) {
			console.log( "using classic analytics.js not yet implemented" );
		}
  }

	// Detection can be done in the bound click event.
	// But here it detects the directly loaded script and not the script imported from inside of the direct script.
	// So in case of gtag.js it includes analytics.js script which does not have to be detected but it is not important.
	 // We should also examine scripts included in GTM.
	var detectedGAType = getGAtype();

	if ( detectedGAType === null ){
		console.log( "no analytics detected" );
		return;
	}

  $( ".iobject.iobject--file > a" ).on( "click", function( event ) { doClick( event ); } );
} ) ( window.jQuery );

