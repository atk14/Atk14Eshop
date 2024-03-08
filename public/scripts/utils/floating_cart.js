window.UTILS = window.UTILS || { };

/**
 * Floating cart show/hide depending on visibility of main cart indicator
 * Usage: 
 * new window.UTILS.floatingCart();
 */


// Floating cart info show/hide
window.UTILS.floatingCart = class {
  floatingCartElement = document.querySelector( ".js--basket_info_float-container" );
  navbarCartElement = document.querySelector( ".js--mainbar__cartinfo" );

  constructor() {
    if ( "IntersectionObserver" in window && this.floatingCartElement && this.navbarCartElement ) {
      let viewportObserver = new IntersectionObserver( this.updateCartVisibility.bind( this ), {
        root: null, // relative to document viewport 
        rootMargin: "0px", // margin around root. Values are similar to css property. Unitless values not allowed
        threshold: 0.75 // visible amount of item shown in relation to root
      } );
      viewportObserver.observe( this.navbarCartElement );
    }
  }

  updateCartVisibility( changes ) {
    changes.forEach( function( change ) {
      if ( change.isIntersecting ) {
        this.floatingCartElement.classList.remove( "show" );
      } else {
        this.floatingCartElement.classList.add( "show" );
      }
    }.bind( this ) );
  }

};
