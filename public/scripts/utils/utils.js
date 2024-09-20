// This is a place for some tools required in the application
import { Popover } from "bootstrap"
//import stickySidebarV2 from 
import StickySidebar from "sticky-sidebar-v2"


window.UTILS = window.UTILS || { };

/** Color conversion from RGBa to hex, alpha is discarded
 * Usage:
 * window.UTILS.rgba2hex( "rgb(255,0,255, 0.5)" ); // returns "ff00ff"
 */
window.UTILS.rgba2hex = function( orig ) {
	var a,
	rgb = orig.replace(/\s/g, "").match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
	alpha = (rgb && rgb[4] || "").trim(),
	hex = rgb ?
	( rgb[ 1 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 2 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 3 ] | 1 << 8 ).toString( 16 ).slice( 1 ) : orig;

	if ( alpha !== "" ) {
		a = alpha;
	} else {
		a = 0o1;
	}
	// multiply before convert to HEX
	a = ( ( a * 255 ) | 1 << 8 ).toString( 16 ).slice( 1 );
	hex = hex + a;

	return hex;
};

/** Color conversion from RGB to hex
 * Usage:
 * window.UTILS.rgb2hex( "rgb(255,0,255)" ); // returns "ff00ff"
 */
window.UTILS.rgb2hex = function( orig ) {
	var
	rgb = orig.replace(/\s/g, "").match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
	hex = rgb ?
	( rgb[ 1 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 2 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 3 ] | 1 << 8 ).toString( 16 ).slice( 1 ) : orig;

	return hex;
};

// Form hints.
window.UTILS.formHints = function() {
	$( ".help-hint" ).each( function() {
		var $this = $( this ),
			$field = $this.closest( ".form-group" ).find( ".form-control" ),
			title = $this.data( "title" ) || "",
			content = $this.html(),
			popoverOptions = {
				html: true,
				trigger: "focus",
				title: title,
				content: content
			};

		//$field.popover( popoverOptions );
		new Popover( $field.get(0), popoverOptions );
	} );
}

// Check whether login is available.
window.UTILS.loginAvaliabilityChecker = function() {
	/*
	 * Check whether login is available.
	 * Simple demo of working with an API.
	 */
	
	let login = document.querySelector( "#id_login" ),
	m = "Username is already taken.",
	h = "<p class=\"alert alert-danger\" style=\"display: none\" id=\"login_availability_status\">" + m + "</p>";
	login.closest( ".form-group" ).insertAdjacentHTML( "beforeend", h );
	let status = document.querySelector( "#login_availability_status" );

	login.addEventListener( "change", async () => {

		// Login input value to check.
		let value = login.value,
		lang = document.querySelector( "html").getAttribute( "lang" ),
		// API URL.
		url = new URL( "/api/" + lang + "/login_availabilities/detail/", window.location.origin ),
		// GET values for API. Available formats: xml, json, yaml, jsonp.
		data = {
			login: value,
			format: "json"
		};

		url.search = new URLSearchParams( data ).toString();


		if ( value !== "" ) {
			try {
				const response = await fetch( url );
				const responseData = await response.json();
				if( responseData.status !== "available" ) {
					window.UTILS.show( status );
				} else {
					window.UTILS.hide( status );
				}
			} catch ( error ){
        console.log( "Error Fetching data ",error);
    	}
		} else {
			window.UTILS.hide( status );
		}

	} );

	login.dispatchEvent(new Event( "change" ));

}

// Restores email addresses misted by the no_spam helper
window.UTILS.unobfuscateEmails = function() {
	$( ".atk14_no_spam" ).unobfuscate( {
		atstring: "[at-sign]",
		dotstring: "[dot-sign]"
	} );
}

// Links with the "blank" class are pointing to new window
window.UTILS.linksTargetBlank = function() {
	$( "a.blank" ).attr( "target", "_blank" );
}

// Expanding/collapsing FAQ items
window.UTILS.initFAQ = function() {
	$( "dl.faq dt, ul.faq .faq__q, ol.faq .faq__q" ).on( "click", function( e ) {
		var qtitle =$( e.target );
		var qcontent = qtitle.next()
		qtitle.toggleClass( "expanded" );
		if ( qtitle.hasClass( "expanded" ) ) {
			qcontent.slideDown( "fast" );
		} else {
			qcontent.slideUp( "fast" );
		}
	} );
}

// Set proper scale for product card image scaling on hover
window.UTILS.setCardHoverScale = function() {
	// find card image
	var cardImage = $( ".section--list-products .card .card-img-top" );
	if( cardImage.length > 0 ) {
		// access to values stored in css variables
		var r = document.querySelector( ":root " );
		var rs = getComputedStyle( r );
		// get card image actual width (CAUTION: assumes all cards are the same width)
		var cardW = $( ".section--list-products .card .card-img-top" ).width();
		// read desired hover width from css
		var imgW = rs.getPropertyValue( "--card_hover_width" );
		var hoverScale = imgW / cardW;
		//console.log( {cardW}, {imgW}, {hoverScale} );
		// set desired scale value to css variable
		r.style.setProperty( "--card_hover_scale", hoverScale );
	}
};

// Sticky Scroll Sidebar
// To make it work enable sticky-sidebar.js in vendorScripts list in gulpfile.js
window.UTILS.initStickySidebar = function() {
	if( $( "nav.nav-section" ).length && typeof StickySidebar !== "undefined" ) {
		if( $( ".body__sticky-container" ).length ) {
			// eslint-disable-next-line no-undef,no-unused-vars
			var sidebar = new StickySidebar( ".nav-section", {
				topSpacing: 10,
				bottomSpacing: 10,
				containerSelector: ".body__sticky-container",
				innerWrapperSelector: "#sidebar_menu",
				minWidth: 767,
			} );
		}
	}
	if( $( "nav.nav-section" ).length ) {
		$( ".nav-section" ).find( ".js-sidebar-toggle" ).on( "click", function() {
			$( ".nav-section" ).toggleClass( "show-sm" );
		} );
	}
	[ ...document.querySelectorAll( "a.blank" ) ].forEach( (elem) => {
		elem.setAttribute( "target", "_blank" )
	} );
}