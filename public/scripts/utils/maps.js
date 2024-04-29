/**
 * Classes for display of maps using Leaflet library.
 * Various tile providers may be used, most notable are Mapy.cz and Openstreetmaps.org
 * 
 * window.UTILS.simpleMap: simple class to display single location with marker
 * 
 * window.UTILS.multiMap: class to display multiple clustered markers with popups
 * 
 * Dependencies: Leaflet - https://leafletjs.com/
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

  // Marker icon options
  iconOptions: {
    iconUrl: "/public/dist/images/map-marker-red.svg",
    iconSize: [30, 42],
    iconAnchor: [15, 42],
    popupAnchor: [0, -40],
  },
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
  iconOptions = window.UTILS.mapOptions.iconOptions;

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
    this.marker = L.marker( [this.lat, this.lng], { icon: L.icon( this.iconOptions ) } ).addTo( this.map );
    if( this.title ) {
      this.marker.bindPopup( this.title );
    }
  }
};

window.UTILS.customMapIcon = L.Icon.extend( {
  options: window.UTILS.mapOptions.iconOptions
} );

/**
 * Multiple locations map
 */
window.UTILS.MultiMap = class {
  mapContainer; // main html container for map
  map; // map instance
  iconOptions = window.UTILS.mapOptions.iconOptions;
  icon = window.UTILS.mapOptions.icon;
  storeData = storeLocatorData;
  //markers = new Array();
  markerGroup;
  clusteredLayer;
  cards = new Array();
  positions = new Array();
  baseMapLayer;
  //storeCardsContainer;
  //storeCards;
  enableClusters = false;
  clusterDistance = 80;
  proximityOffset = 20;

  constructor( mapElement ) {
    this.mapContainer = mapElement;
    console.log("new MultiMap", this.mapContainer );
    //this.storeCardsContainer = this.mapContainer.querySelector( ".js-stores-cards" );
    //this.storeCards = this.storeCardsContainer.querySelectorAll( ".js-store-item" );
    this.enableClusters = (/true/).test( this.mapContainer.dataset.enable_clusters );
    this.clusterDistance = this.mapContainer.dataset.cluster_distance;

    
    
    this.baseMapLayer = L.tileLayer( window.UTILS.mapOptions.mapProvider, { 
      attribution: window.UTILS.mapOptions.mapAttribution 
    } );

    console.log( "clusters", this.enableClusters, typeof(this.enableClusters) );
    console.log( "spiderify", this.spiderify, typeof(this.spiderify) );
    if( this.enableClusters ) {
      console.log("yers");
      this.markerGroup = L.markerClusterGroup( {
        showCoverageOnHover: false,
        maxClusterRadius: this.clusterDistance,
        iconCreateFunction: this.customClusterIcon,
      } );
    } else {
      console.log("nieet");
      this.markerGroup = new L.featureGroup();
      this.calculateMarkerOffsets();
    }

    this.createMarkers();


    // Create map
    const tempCenter = [ 50.0736203, 14.4234447 ];
    this.map = L.map( this.mapContainer, {
      center: tempCenter,
      zoom: 10,
      layers: [ this.baseMapLayer, this.markerGroup ],
    });

    // Zoom to show all markers
    this.map.fitBounds( this.markerGroup.getBounds() );
  }

  /**
   * If there are more markers in the same location,
   * let`s calculate x offset so they don`t overlap
   * (3 decimals precision)
   */
  calculateMarkerOffsets() {
    for ( let i = 0; i < this.storeData.length; i++ ) {
      let iLat = Number( Math.round( this.storeData[ i ].lat + "e3" ) + "e-3" );
      let iLng = Number( Math.round( this.storeData[ i ].lng + "e3" ) + "e-3" );
      this.storeData[ i ].markerOffset = 0;
      for ( let j = 0; j < i; j++ ) {
        let jLat = Number( Math.round( this.storeData[ j ].lat + "e3" ) + "e-3" );
        let jLng = Number( Math.round( this.storeData[ j ].lng + "e3" ) + "e-3" );
        if ( iLat === jLat && iLng === jLng ) {
          this.storeData[ i ].markerOffset++;
        }
      }
    }
  }

  /**
   * Create and place markers
   */
  createMarkers() {
    for ( let i = 0; i < this.storeData.length; i++ ) {
      let store  = this.storeData[ i ]
      let id = store.id;
      let icon = L.icon( this.iconOptions )

      // Make icon with X offset if needed
      if( !this.enableClusters && store.markerOffset !== 0 ) {
        console.log( "has offset" );
        let iconAnchorX = this.iconOptions.iconAnchor [0];
        let iconAnchorY = this.iconOptions.iconAnchor [1];
        let popupAnchorX = this.iconOptions.popupAnchor [0];
        let popupAnchorY = this.iconOptions.popupAnchor [1];

        icon = new window.UTILS.customMapIcon( { 
          iconAnchor:  [ iconAnchorX + ( store.markerOffset * this.proximityOffset ), iconAnchorY ],
          popupAnchor: [ popupAnchorX - ( store.markerOffset * this.proximityOffset ), popupAnchorY ],
        } );
      }

      let marker = L.marker( [ store.lat, store.lng ], { icon: icon } ).bindPopup( store.title + " :] " );
      //this.markers.push( marker );
      this.markerGroup.addLayer( marker );
    }
  }

  customClusterIcon( cluster ) {
    return L.divIcon({ html: cluster.getChildCount(), className: "map-cluster", iconSize: L.point(40, 40) });
  }

};
