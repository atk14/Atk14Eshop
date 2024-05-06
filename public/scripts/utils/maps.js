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
window.UTILS.mapHelpers = class {

  // Tile provider API URL
  static get mapProvider() {
    let tileURL = null;
    let APIKey = "";
    if( window.mapTilesAPIkey ) {
      // Get tile API key which should be writen in page source
      APIKey = window.mapTilesAPIkey;
    }
    switch( this.getTileProvider() ) {
      case "mapycz":
        tileURL = `https://api.mapy.cz/v1/maptiles/basic/256/{z}/{x}/{y}?apikey=${APIKey}`;
        break;
      case "osm":
      default:
        tileURL = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
    }
    return tileURL;
  };

  // Tile attribution as tile provider requires
  static get mapAttribution() {
    let attribution = null;
    switch( this.getTileProvider() ) {
      case "mapycz":
        attribution = "<a href=\"https://api.mapy.cz/copyright\" target=\"_blank\">&copy; Seznam.cz a.s. a další</a>";
        break;
      case "osm":
      default:
        attribution = "&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors";
    }
    return attribution;
  }

  // Marker icon options
  static iconOptions = {
    iconUrl: "/public/dist/images/map-marker-red.svg",
    iconSize: [30, 42],
    iconAnchor: [15, 42],
    popupAnchor: [0, -40],
  };

  // Get tile provider which should be writen in page source
  static getTileProvider() {
    if( window.mapTilesProvider ){
      return window.mapTilesProvider;
    } else {
      return "osm";
    }
  }

  // Get tile provider logo required by tile provider
  static addTileProviderLogo( map ) {
    if( this.getTileProvider() === "mapycz" ) {
      const LogoControl = L.Control.extend({
        options: {
          position: "bottomleft",
        },
      
        // eslint-disable-next-line no-unused-vars
        onAdd: function ( map ) {
          const container = L.DomUtil.create( "div" );
          const link = L.DomUtil.create( "a", "", container );
      
          link.setAttribute( "href", "http://mapy.cz/" );
          link.setAttribute( "target", "_blank" );
          link.innerHTML = "<img src=\"https://api.mapy.cz/img/api/logo.svg\">";
          L.DomEvent.disableClickPropagation( link );
      
          return container;
        },
      });
      new LogoControl().addTo( map );
    }
  }
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
  iconOptions = window.UTILS.mapHelpers.iconOptions;
  baseMapLayer;

  constructor( mapElement) {
    this.mapElement = mapElement;
    this.lat = this.mapElement.dataset.lat;
    this.lng = this.mapElement.dataset.lng;
    this.zoom = this.mapElement.dataset.zoom;
    this.title = this.mapElement.dataset.title;

    // Create basemap tile layer
    this.baseMapLayer = L.tileLayer( window.UTILS.mapHelpers.mapProvider, { 
      attribution: window.UTILS.mapHelpers.mapAttribution 
    } );

    // Create map
    this.map = L.map( this.mapElement, {
      center: [this.lat, this.lng],
      zoom: this.zoom,
      gestureHandling: true,
      layers: [ this.baseMapLayer ],
    } );

    // Add marker
    this.marker = L.marker( [this.lat, this.lng], { icon: L.icon( this.iconOptions ) } ).addTo( this.map );
    if( this.title ) {
      this.marker.bindPopup( this.title );
    }

    // Add provider logo if required
    window.UTILS.mapHelpers.addTileProviderLogo( this.map );
  }
};

/**
 * Function for creating custom map icons
 */
window.UTILS.customMapIcon = L.Icon.extend( {
  options: window.UTILS.mapHelpers.iconOptions
} );

/**
 * Multiple locations map
 */
window.UTILS.MultiMap = class {
  mapContainer; // main html container for map
  map; // map instance
  iconOptions = window.UTILS.mapHelpers.iconOptions;
  icon = window.UTILS.mapHelpers.icon;
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
    // console.log("new MultiMap", this.mapContainer );
    this.enableClusters = (/true/).test( this.mapContainer.dataset.enable_clusters );
    this.clusterDistance = this.mapContainer.dataset.cluster_distance;
    if ( this.mapContainer.querySelector( this.preloaderSelector ) ) {
      this.preloader = this.mapContainer.querySelector( this.preloaderSelector );
    }

    // initialize base map tiles layer
    this.baseMapLayer = L.tileLayer( window.UTILS.mapHelpers.mapProvider, { 
      attribution: window.UTILS.mapHelpers.mapAttribution 
    } );

    // initialize layer for markers
    if( this.enableClusters ) {
      this.markerGroup = L.markerClusterGroup( {
        showCoverageOnHover: false,
        maxClusterRadius: this.clusterDistance,
        iconCreateFunction: this.customClusterIcon,
      } );
    } else {
      this.markerGroup = new L.featureGroup();
      this.calculateMarkerOffsets();
    }

    // Create markers
    this.createMarkers();

    // Show / hide preloader
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

    // Add provider logo if required
    window.UTILS.mapHelpers.addTileProviderLogo( this.map );

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
    const address = decodeURIComponent( store.address );
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
        <address>${address}</address>
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
    if( !document.querySelector( this.cardListSelector ) ) {
      return;
    }
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
    if( this.preloader ) {
      if ( visibility ) {
        this.preloader.style.display = "flex";
      } else {
        this.preloader.style.display = "none";
      }
    }
  }


};
