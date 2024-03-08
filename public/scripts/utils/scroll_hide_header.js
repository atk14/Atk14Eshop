window.UTILS = window.UTILS || { };	
/**
 * Hides header on scroll down.
 * 
 * Usage:
 * window.UTILS.hideHeaderOnScroll();
 * 
 * Disabled by default. To enable this functionality:
 * - uncomment this file path in gulpfile.js and uncomment corresponding line in application.js
 * - add data-scrollhideheader="true" attribute to body tag
 */
window.UTILS.hideHeaderOnScroll = function() {
  var $ = window.jQuery;
  if( $( "body" ).attr( "data-scrollhideheader" ) === "true" ) {
		var prevScroll = document.documentElement.scrollTop || window.scrollY;
		var  direction = "";
		var prevDirection = ""

		var handleHideScroll = function() {
			var currScroll = document.documentElement.scrollTop || window.scrollY;

			if ( currScroll > prevScroll ) {

				// Scrolled up
				direction = "up";
			} else if ( currScroll < prevScroll ) {

				//scrolled down
				direction = "down";
			}

			if ( direction !== prevDirection ) {
				toggleHeader( direction, currScroll );
			}

			prevScroll = currScroll;
		}

		var toggleHeader = function( direction, currScroll ) {
			var header = document.getElementById ( "header-main" );
			var docBody = document.getElementById ( "page-body" );
			var headerHeight = header.offsetHeight;
			if( currScroll > headerHeight + 50 ) {
				
				// Scrolled down
				$( header ).css( "position", "fixed" );
				$( header ).css( "top", ( 0 - headerHeight ) + "px" );
				docBody.style.paddingTop = headerHeight + 40 + "px";
			} else {
				
				// Top
				$( header ).css( "position", "static" );
				$( header ).css( "top", ( 0 - headerHeight ) + "px" );
				docBody.style.paddingTop = 0 + "px";
			}
			if ( direction === "up" && currScroll > headerHeight ) {
				
				// Scrolled down, hidden
				$( header ).css( "top", ( 0 - headerHeight ) + "px" );
				
			} else if ( direction === "down" ) {
				
				// Scrolled down, shown
				$( header ).css( "top", "0px" );
			}

			prevDirection = direction;
		};

		window.addEventListener( "scroll", handleHideScroll );
		window.addEventListener( "resize", handleHideScroll );
	}
};