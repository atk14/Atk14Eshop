window.UTILS = window.UTILS || { };

/*
  Bootstrap offcanvas overlay
  based on 
  https://github.com/as-tx/bootstrap-off-canvas-sidebar/blob/master/accessibility-demo.html
  https://fellowtuts.com/html-css/off-canvas-menu-sidebar-overlay/
  https://as-tx.github.io/bootstrap-off-canvas-sidebar/offset-overlay-full-demo.html
*/

window.UTILS.initOffCanvas = function() {
  var $ = window.jQuery;
  console.log( "offcanvas init" );
	var bsOverlay = $( ".bs-canvas-overlay" );
	$( "[data-toggle='canvas']" ).on( "click", function() {
		var ctrl = $(this), 
		elm = ctrl.is( "button" ) ? ctrl.data( "target" ) : ctrl.attr( "href" );
		$( elm ).addClass( "mr-0" );
		$( elm + " .bs-canvas-close" ).attr( "aria-expanded", "true" );
		$( "[data-target='" + elm + "'], a[href='" + elm + "']" ).attr( "aria-expanded", "true" );
		if( bsOverlay.length ) {
			bsOverlay.addClass( "show" );
    }
		return false;
	} );
	
	$( ".bs-canvas-close, .bs-canvas-overlay" ).on( "click", function() {
		var elm;
		if( $( this ).hasClass( "bs-canvas-close" ) ) {
			elm = $( this ).closest( ".bs-canvas" );
			$( "[data-target='" + elm + "'], a[href='" + elm + "']" ).attr( "aria-expanded", "false" );
		} else {
			elm = $( ".bs-canvas" );
			$( "[data-toggle='canvas']" ).attr( "aria-expanded", "false" );	
		}
		elm.removeClass( "mr-0" );
		$( ".bs-canvas-close", elm ).attr( "aria-expanded", "false" );
		if( bsOverlay.length ) {
			bsOverlay.removeClass( "show" )
    };
		return false;
	} );
};

window.UTILS.initOffCanvas();