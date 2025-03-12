
/**
 * Main JS module for the application. It is used mainly for loading other JS modules.
 */
import PhotoswipeLoader from "./photoswipeloader.js";
import SwiperLoader from "./swiperloader.js";
import { SimpleMap, MultiMap } from "./maps.js";


// Photoswipe

// Check if Photoswipe is needed on the page and if so, load it
if( document.querySelector( ".gallery__images, .iobject--picture" ||  document.querySelector( ".js_gallery_trigger" )) ) {
  PhotoswipeLoader.load();
} else {
  // console.info( "No Photoswipe needed on this page" );
}

// Swiper

// Check if Swiper is needed on the page and if so, load it
if( document.querySelector( ".swiper" ) ) {
  SwiperLoader.load();
}else {
  // console.info( "No Swiper needed on this page" );
}

// Maps
// Simple maps (single marker)
document.querySelectorAll( ".map_v2" ).forEach( function( mapElement ) {
  new SimpleMap( mapElement );
} );
// Multi maps (multiple markers)
document.querySelectorAll( ".stores_v2" ).forEach( function( mapElement ) {
  new MultiMap( mapElement );
} );