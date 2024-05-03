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
  baseMapLayer;

  constructor( mapElement) {
    this.mapElement = mapElement;
    console.log("new SimpleMap", this.mapElement);
    this.lat = mapElement.dataset.lat;
    this.lng = mapElement.dataset.lng;
    this.zoom = mapElement.dataset.zoom;
    this.title = mapElement.dataset.title;
    this.baseMapLayer = L.tileLayer( window.UTILS.mapOptions.mapProvider, { 
      attribution: window.UTILS.mapOptions.mapAttribution 
    } );
    this.map = L.map( this.mapElement, {
      center: [this.lat, this.lng],
      zoom: this.zoom,
      gestureHandling: true,
      layers: [ this.baseMapLayer ],
    } );    
    this.marker = L.marker( [this.lat, this.lng], { icon: L.icon( this.iconOptions ) } ).addTo( this.map );
    if( this.title ) {
      this.marker.bindPopup( this.title );
    }
  }
};

/**
 * Function for creating custom map icons
 */
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
  storeData = window.storeLocatorData;
  markerGroup;
  clusteredLayer;
  cards = new Array();
  positions = new Array();
  baseMapLayer;
  enableClusters = false;
  clusterDistance = 80;
  proximityOffset = 20;
  cardListSelector = ".js-stores-cards";
  cardListItemSelector = ".js-store-item";
  cardListMapButtonSelector = ".js-store-mapbtn";
  preloaderSelector = ".preloader";
  preloader;

  constructor( mapElement ) {
    this.mapContainer = mapElement;
    console.log("new MultiMap", this.mapContainer );
    this.enableClusters = (/true/).test( this.mapContainer.dataset.enable_clusters );
    this.clusterDistance = this.mapContainer.dataset.cluster_distance;
    this.preloader = this.mapContainer.querySelector( this.preloaderSelector );

    
    
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

    this.baseMapLayer.addEventListener( "loading", function(){ this.preloaderVisible = true }.bind( this ) );
    this.baseMapLayer.addEventListener( "load", function(){ this.preloaderVisible = false }.bind( this ) );

    // Create map
    const tempCenter = [ 50.0736203, 14.4234447 ];
    this.map = L.map( this.mapContainer, {
      center: tempCenter,
      zoom: 10,
      layers: [ this.baseMapLayer, this.markerGroup ],
      gestureHandling: true,
    });

    // Zoom to show all markers
    this.map.fitBounds( this.markerGroup.getBounds() );

    // Connect list of points with map
    this.createCardListHandlers();

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
      let store  = this.storeData[ i ];
      let icon = L.icon( this.iconOptions );

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

      let marker = L.marker( [ store.lat, store.lng ], { icon: icon } ).bindPopup( this.createPopupMarkup( store ) );
      marker.storeId = store.id;
      console.log( {marker} );
      this.markerGroup.addLayer( marker );
    }
  }

  customClusterIcon( cluster ) {
    return L.divIcon({ html: cluster.getChildCount(), className: "map-cluster", iconSize: L.point(40, 40) });
  }

  /*
    Create HTML markup for marker popup
  */
  createPopupMarkup(store) {
    let image = "";
    let flags = "";
    const address = decodeURIComponent( store.address );console.log(store.isOpen, typeof(store.isOpen));
    if( store.isOpen !== false && typeof( store.isOpen ) === "string" ){
			flags = `<div class="flags"><span class="badge badge-success">${store.isOpen}</span></div>`;
		}
    if( store.image ) {
      image = `<img src="${store.image}" alt="${store.title}">`;
    }
    let template = `
    <div class="map-info-popup">
      <div class="map-info-popup__header">
      ${image}${flags}
      </div>
      <div class="map-info-popup__body">
        <p class="map-info-popup__title">${store.title}</p>
        <address>${address}</address>-${store.id}-
        <a href="${store.detailURL}" class="btn btn-sm btn-primary">Prodejna <span class="fas fa-arrow-right"></span></a>
      </div>
    </div>
    `;

    return template;
  }

  /**
   * Create click handlers on stores list to show store on map
   */
  createCardListHandlers() {
    const cardContainer = document.querySelector( this.cardListSelector );
    const cards = cardContainer.querySelectorAll( this.cardListItemSelector );
    [...cards].forEach( function( elem ){
      elem.querySelector( this.cardListMapButtonSelector ).addEventListener( "click", this.showPopupByStoreId.bind( this ) );
    }.bind( this ) );
  }

  /**
   * Show info popup by store ID
   * @param {*} e 
   */
  showPopupByStoreId( e ) {
    e.preventDefault();
    console.log( "CICLK ON LIST", e.currentTarget.dataset.storeid );
    const marker = this.getMarkerByStoreId( e.currentTarget.dataset.storeid );

    if( this.enableClusters ){
      this.markerGroup.zoomToShowLayer( marker, function(){ setTimeout( function(){ marker.openPopup()}, 500 ) } );
    } else {
      const  pos = [ marker.getLatLng() ];
      const markerBounds = L.latLngBounds( pos );
      this.map.fitBounds( markerBounds );
    }

    marker.openPopup();
    
    this.mapContainer.scrollIntoView( { behavior: "smooth" } );
  }

  /**
   * Find marker by store ID
   */
  getMarkerByStoreId( storeId ) {
    let marker;
    this.markerGroup.eachLayer( function ( layer ) {
      if( layer.storeId.toString() === storeId.toString() ) {
        marker = layer;
      }
    } );
    return marker;
  }

  /**
   * controls preloader visibility
   */
  set preloaderVisible( visibility ){
    if ( visibility ) {
      this.preloader.style.display = "flex";
    } else {
      this.preloader.style.display = "none";
    }
  }


};
