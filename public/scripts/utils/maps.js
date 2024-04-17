/**
 * Classes for display of maps using Leaflet library.
 * Various tile providers may be used, most notable are Mapy.cz and Openstreetmaps.org
 * 
 * window.UTILS.simpleMap: simple class to display single location with marker
 * 
 * window.UTILS.multiMap: class to display multiple clustered markers with popups
 * 
 */

window.UTILS = window.UTILS || { };

/**
 * General map options
 */
window.UTILS.mapOptions = {

  // Tile provider API URL
  mapProvider: "https://tile.openstreetmap.org/{z}/{x}/{y}.png",

  // Tile attribution as tile provider requires
  mapAttribution: "&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors",

  // Marker icon
  icon: L.icon( {
    iconUrl: "/public/dist/images/map-marker-red.svg",
    iconSize: [30, 42],
    iconAnchor: [15, 42],
    popupAnchor: [0, -40],
  } ),
};


/**
 * Simple map with marker
 * Marker position, default zoom and optional title are set as data attributes.
 * Usage:
 * HTML:
 * <div class="my_map" id="store-map" data-lat="50.0770708" data-lng="14.4862577" data-zoom="16" data-title="Elegantní lékárna"></div>
 * JS:
 * window.UTILS.new SimpleMap( document.querySelector( ".my_map" ) );
 */
window.UTILS.SimpleMap = class {
  mapElement;
  lat;
  lng;
  zoom;
  title;
  map;
  marker;
  icon = window.UTILS.mapOptions.icon;

  constructor( mapElement) {
    this.mapElement = mapElement;
    console.log("new SimpleMap", this.mapElement);
    this.lat = mapElement.dataset.lat;
    this.lng = mapElement.dataset.lng;
    this.zoom = mapElement.dataset.zoom;
    this.title = mapElement.dataset.title;
    this.map = L.map( this.mapElement ).setView( [this.lat, this.lng], this.zoom );
    L.tileLayer( window.UTILS.mapOptions.mapProvider, { 
      attribution: window.UTILS.mapOptions.mapAttribution 
    } ).addTo( this.map );
    this.marker = L.marker( [this.lat, this.lng], { icon: this.icon } ).addTo( this.map );
    if( this.title ) {
      this.marker.bindPopup( this.title );
    }
  }
}