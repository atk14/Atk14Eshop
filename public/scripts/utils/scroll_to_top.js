window.UTILS = window.UTILS || { };	
/**
 * Back to top button display and handling
  */ 
window.UTILS.scrollToTopBtn = function() {
  window.addEventListener( "scroll", function() {
    let backToTopBtn = this.document.querySelector( "#js-scroll-to-top" );
    if( window.scrollY  > 100 ) {
      backToTopBtn.classList.add( "active" );
    } else {
      backToTopBtn.classList.remove( "active" );
    }
  } );

  window.dispatchEvent( new Event( "scroll" ) );

  let scrollTopBtn = document.querySelector( "#js-scroll-to-top" );
  if( scrollTopBtn ){
    scrollTopBtn.addEventListener( "click", function( e ) {
      e.preventDefault();
      let els = document.querySelectorAll( "html,body" );
      console.log( "els", els );
      window.scroll( { top: 0, left: 0, behavior: "smooth" } );
    } );
  }
};