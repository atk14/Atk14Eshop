
/**
 * Main JS module for the application. It is used mainly for loading other JS modules.
 */
import PhotoswipeLoader from "./photoswipeloader.js";
import SwiperLoader from "./swiperloader.js";
//import L from  "../../../node_modules/leaflet/dist/leaflet-src.esm.js";
//console.log( "Leaflet L loaded? ...", L );
//let mapsModule = import ("./maps.js");
//import SimpleMaps from "./maps.js";
// const lm = import ( "../../../node_modules/leaflet/dist/leaflet-src.esm.js" ); // seems working
// console.log( "Leaflet loaded? ...", lm );
/*import {SimpleMap, MultiMap, MapHelpers} from "./maps.js";
console.log( "SimpleMap loaded? ...", SimpleMap );
console.log( "MultiMap loaded? ...", MultiMap ); 
console.log( "MapHelpers loaded? ...", MapHelpers ); */
import { MapBase, SimpleMap } from "./maps.js";
const t = new SimpleMap( document.querySelector( "#store-map" ) );
console.log( "MapTest loaded? ...", t );
console.log( "MapTest loaded? ...", t );
console.log( "MapBase loaded? ...", MapBase );

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
//console.log( "Maps loaded? ...", SimpleMaps );
/*try {
  let leaflet = await import( "../../../node_modules/leaflet/dist/leaflet-src.esm.js" );
  console.log( "Leaflet loaded? ...", leaflet,  leaflet.default, leaflet.L );
}
catch( error ) {
  console.error( "Error loading Leaflet", error);
}*/