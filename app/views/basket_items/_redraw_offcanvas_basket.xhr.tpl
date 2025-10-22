window.basketOffcanvas.redrawBasket( {jstring}{render partial="shared/offcanvas_basket/detail"}{/jstring} );

[...document.querySelectorAll( ".js--basket_info_content" )].forEach( function( el ) {
  el.parentNode.innerHTML = {jstring}{render partial="shared/basket_info_content"}{/jstring};
} );

window.dispatchEvent( new Event( "basket_updated" ) );

