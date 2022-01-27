window.UTILS = window.UTILS || { };

window.UTILS.CartPreview = function( options ) {
	this.options = options;
	var self = this;

  // Delay on trigger mouse out
  this.options.delay = this.options.delay || 1000;

  // Viewport size breakpoint
  this.options.displayBreakpoint = this.options.displayBreakpoint || 600;

  // Cart preview popup
  this.cartPopup = $( ".js--basket-preview" );

  // Is cart prview visible?
  this.cartShown = false;

  // Interval ID for timeout before delayed hide
  this.intervalID = 0;

  // Show cart
  this.showCart = function( e ) {

    // cancel on small screen
    if( $( window ).width < self.displayBreakpoint ) {
      if( self.cartShown ){
        self.hideCart();
      }
      return;
    }

    // Cancel hide timeout
    self.keepCartOpen();

    // Show cart popup if hidden
    if( !self.cartShown ) {

      // TODO: remote basket content load

      self.cartPopup.addClass( "show" );
      var target = $( e.currentTarget );
      self.cartPopup.css( "top", target.offset().top + "px" );
      self.cartPopup.css( "left", ( target.offset().left - 400 ) + "px");
      self.cartShown = true;
    }
  };

  // Hide cart popup
  this.hideCart = function() {
    if( self.intervalID ){
      clearInterval( self.intervalID );
      self.intervalID = 0;
    }
    self.cartPopup.removeClass( "show" );
    self.cartShown = false;
  }

  // Cancel scheduled hide on mouse re-enter
  this.keepCartOpen = function(){
    if( self.intervalID ) {
      clearInterval( self.intervalID );
      self.intervalID = 0;
    }
    self.cartPopup.removeClass( "basket-preview--fading" );
  }

  // Set up event handlers
  if( this.options.triggers.length && this.cartPopup.length ) {

    // Mouse enters trigger - show cart
    this.options.triggers.on( "mouseenter", this.showCart );

    // Mouse leaves trigger - schedule delayed hide
    this.options.triggers.on( "mouseleave", function() {
      self.cartPopup.addClass( "basket-preview--fading" );
      self.intervalID = setTimeout( self.hideCart, self.options.delay );
    } );

    // Mouse enters popup - cancel scheduled hide
    this.cartPopup.on( "mouseenter", this.keepCartOpen );

    // Mouse leaves popup - hide immediately
    this.cartPopup.on( "mouseleave", this.hideCart );
  }
};