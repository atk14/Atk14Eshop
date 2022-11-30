window.UTILS = window.UTILS || { };

/*
  Bootstrap offcanvas overlay
  based on 
  https://github.com/as-tx/bootstrap-off-canvas-sidebar/blob/master/accessibility-demo.html
  https://fellowtuts.com/html-css/off-canvas-menu-sidebar-overlay/
  https://as-tx.github.io/bootstrap-off-canvas-sidebar/offset-overlay-full-demo.html
*/

window.UTILS.BSOffCanvas = function() {

  var $ = window.jQuery;

  var offCanvasShowEvent = new Event( "bs-offcanvas-show" );
  var offCanvasHideEvent = new Event( "bs-offcanvas-hide" );

	var bsOverlay = $( ".bs-offcanvas-overlay" );

	// Show offcanvas on click 
	$( "[data-toggle='offcanvas']" ).on( "click", function( e ) {
		e.preventDefault();
		var ctrl = $(this), 
		elm = ctrl.data( "target" ) ? ctrl.data( "target" ) : ctrl.attr( "href" );
		$( elm ).addClass( "mr-0" );
		$( elm + " .bs-offcanvas-close" ).attr( "aria-expanded", "true" );
		$( "[data-target='" + elm + "'], a[href='" + elm + "']" ).attr( "aria-expanded", "true" );
    $( elm ).get( 0 ).dispatchEvent( offCanvasShowEvent );
    $( "body" ).addClass( "offcanvas-visible" );
		if( bsOverlay.length ) {
			bsOverlay.addClass( "show" );
    }
	} );
	
	// Hide offcanvas on click on close button or overlay
	$( ".bs-offcanvas-close, .bs-offcanvas-overlay" ).on( "click", function( e ) {
		e.preventDefault();
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
    $( "body" ).removeClass( "offcanvas-visible" );
		$( ".bs-offcanvas-close", elm ).attr( "aria-expanded", "false" );
		if( bsOverlay.length ) {
			bsOverlay.removeClass( "show" )
    };		
	} );

	// Show offcanvas manually. "bs-offcanvas-show" event will be NOT fired.
	this.showOffCanvas = function ( elm, fireEvent ) {
		$( elm ).addClass( "mr-0" );
		$( elm + " .bs-offcanvas-close" ).attr( "aria-expanded", "true" );
		$( "[data-target='" + elm + "'], a[href='" + elm + "']" ).attr( "aria-expanded", "true" );
		if( fireEvent === true ){
    	$( elm ).get( 0 ).dispatchEvent( offCanvasShowEvent );
		}
    $( "body" ).addClass( "offcanvas-visible" );
		if( bsOverlay.length ) {
			bsOverlay.addClass( "show" );
    }
	};

	this.hideOffCanvas = function( elm ) {
		$( elm + " .bs-offcanvas-close" ).trigger( "click" );
	}
};

window.UTILS.OffcanvasBasket = function() {
	var $ = window.jQuery;
	var $this = this;
	this.element = $( "#offcanvas-basket .bs-offcanvas-content .basket-content" );
	this.timeoutID = undefined;

	// Load basket content from server
	this.loadBasket = function() {
		$this.element.html( "" );
		if( $this.timeoutID ) {
			clearTimeout( $this.timeoutID );
		}
		$this.updateCountDisplay( null );
		$this.element.attr( "data-status", "loading" );
		$this.element.load( "/cs/baskets/detail", function( response, status, jqXHR ) {
			switch( status ) {
				case "success" :
					$this.element.attr( "data-status", "loaded" );
					$this.updateCountDisplay( $this.getCountDisplay() );
					break;
				case "error" :
					$this.element.attr( "data-status", "error" );
					$this.element.parent().find( ".js--basket-error" ).html( "Error " +  jqXHR.status + ": " + jqXHR.statusText );
					break;
			}
		} );
	};

	// Show basket with custom content
	// window.basketOffcanvas.showCustomBasket( "this is <strong>custom html content</strong>", 3000 );
	this.showCustomBasket = function ( content, timeout ) {
		$this.element.html( content );
		$this.updateCountDisplay( $this.getCountDisplay() );
		$this.element.attr( "data-status", "loaded" );
		window.offCanvas.showOffCanvas( "#offcanvas-basket", false );
		if( timeout ) {
			$this.timeoutID = setTimeout( function() { window.offCanvas.hideOffCanvas( "#offcanvas-basket" ); }, timeout );
		}
	};

	// Get items count from html attr
	this.getCountDisplay = function() {
		var countElem = $this.element.find( "*[data-items-count]" );
		if( countElem.length ) {
			var count = countElem.attr( "data-items-count" );
			return count;
		} else {
			return null;
		}
	};

	// Update items count
	this.updateCountDisplay = function ( count ) {
		var n;
		if( count ) {
			n = count;
		} else {
			n = "";
		}
		$( "#offcanvas-basket" ).find( ".js--cart-num-items" ).text( n );
	};

	// Set handler for basket show event
	$( "#offcanvas-basket" ).on( "bs-offcanvas-show", $this.loadBasket );

};