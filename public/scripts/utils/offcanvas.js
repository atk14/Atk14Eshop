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

  const offCanvasShowEvent = new Event( "bs-offcanvas-show" );
  const offCanvasHideEvent = new Event( "bs-offcanvas-hide" );

  console.log( "offcanvas init" );
	var bsOverlay = $( ".bs-offcanvas-overlay" );
	$( "[data-toggle='offcanvas']" ).on( "click", function() {
    console.log( offCanvasShowEvent );
		var ctrl = $(this), 
		elm = ctrl.is( "button" ) ? ctrl.data( "target" ) : ctrl.attr( "href" );
		$( elm ).addClass( "mr-0" );
		$( elm + " .bs-offcanvas-close" ).attr( "aria-expanded", "true" );
		$( "[data-target='" + elm + "'], a[href='" + elm + "']" ).attr( "aria-expanded", "true" );
    $( elm ).get( 0 ).dispatchEvent( offCanvasShowEvent );
		if( bsOverlay.length ) {
			bsOverlay.addClass( "show" );
    }
		return false;
	} );
	
	$( ".bs-offcanvas-close, .bs-offcanvas-overlay" ).on( "click", function() {
		var elm;
		if( $( this ).hasClass( "bs-offcanvas-close" ) ) {
			elm = $( this ).closest( ".bs-offcanvas" );
			$( "[data-target='" + elm + "'], a[href='" + elm + "']" ).attr( "aria-expanded", "false" );
		} else {
			elm = $( ".bs-offcanvas" );
			$( "[data-toggle='offcanvas']" ).attr( "aria-expanded", "false" );	
		}
		elm.removeClass( "mr-0" );
    elm.get( 0 ).dispatchEvent( offCanvasHideEvent );
		$( ".bs-offcanvas-close", elm ).attr( "aria-expanded", "false" );
		if( bsOverlay.length ) {
			bsOverlay.removeClass( "show" )
    };
		return false;
	} );
};

window.UTILS.initOffCanvas();