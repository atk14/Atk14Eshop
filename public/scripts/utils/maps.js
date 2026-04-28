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
    switch( this.tileProvider ) {
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
    switch( this.tileProvider ) {
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

  static escapeHtml( str ) {
    return String( str )
      .replace( /&/g, "&amp;" )
      .replace( /</g, "&lt;" )
      .replace( />/g, "&gt;" )
      .replace( /"/g, "&quot;" )
      .replace( /'/g, "&#39;" );
  }

  static get tileProvider() {
    return window.mapTilesProvider ?? "osm";
  }

  // Get tile provider logo required by tile provider
  static addTileProviderLogo( map ) {
    if( this.tileProvider === "mapycz" ) {
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
          link.setAttribute( "title", "Mapy.cz" );
          link.innerHTML = "<img src=\"https://api.mapy.cz/img/api/logo.svg\" alt=\"\">";
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
  storeData = window.storeLocatorData ?? [];
  markerGroup;
  clusteredLayer;
  cards = [];
  positions = [];
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
    this.enableClusters = (/true/).test( this.mapContainer.dataset.enable_clusters );
    this.clusterDistance = this.mapContainer.dataset.cluster_distance ?? this.clusterDistance;
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
      this.markerGroup = L.featureGroup();
      this.calculateMarkerOffsets();
    }

    // Create markers
    this.createMarkers();

    // Show / hide preloader
    this.baseMapLayer.addEventListener( "loading", () => { this.preloaderVisible = true; } );
    this.baseMapLayer.addEventListener( "load", () => { this.preloaderVisible = false; } );

    // Create map
    this.map = L.map( this.mapContainer, {
      center: [
        this.mapContainer.dataset.lat ?? 50.0736203,
        this.mapContainer.dataset.lng ?? 14.4234447,
      ],
      zoom: this.mapContainer.dataset.zoom ?? 10,
      layers: [ this.baseMapLayer, this.markerGroup ],
      gestureHandling: true,
    });

    // Add provider logo if required
    window.UTILS.mapHelpers.addTileProviderLogo( this.map );

    // Zoom to show all markers
    if( this.markerGroup.getLayers().length > 0 ) {
      this.map.fitBounds( this.markerGroup.getBounds() );
    }

    // Connect list of points with map
    this.createCardListHandlers();

  }

  /**
   * If there are more markers in the same location,
   * let`s calculate x offset so they don`t overlap
   * (3 decimals precision)
   */
  calculateMarkerOffsets() {
    const round3 = v => Math.round( v * 1000 ) / 1000;
    for ( const [ i, store ] of this.storeData.entries() ) {
      const iLat = round3( store.lat );
      const iLng = round3( store.lng );
      store.markerOffset = 0;
      for ( const prev of this.storeData.slice( 0, i ) ) {
        if ( round3( prev.lat ) === iLat && round3( prev.lng ) === iLng ) {
          store.markerOffset++;
        }
      }
    }
  }

  /**
   * Create and place markers
   */
  createMarkers() {
    for ( const store of this.storeData ) {
      let icon = L.icon( this.iconOptions );

      // Make icon with X offset if needed
      if( !this.enableClusters && store.markerOffset !== 0 ) {
        const [ iconAnchorX, iconAnchorY ] = this.iconOptions.iconAnchor;
        const [ popupAnchorX, popupAnchorY ] = this.iconOptions.popupAnchor;

        icon = new window.UTILS.customMapIcon( {
          iconAnchor:  [ iconAnchorX + ( store.markerOffset * this.proximityOffset ), iconAnchorY ],
          popupAnchor: [ popupAnchorX - ( store.markerOffset * this.proximityOffset ), popupAnchorY ],
        } );
      }

      const marker = L.marker( [ store.lat, store.lng ], { icon: icon } ).bindPopup( this.createPopupMarkup( store ) );
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
    const e = window.UTILS.mapHelpers.escapeHtml;
    let image = "";
    let flags = "";
    const address = decodeURIComponent( store.address );
    if( typeof( store.isOpen ) === "string" ){
      flags = `<div class="flags"><span class="badge badge-success">${store.isOpen}</span></div>`;
    }
    if( store.image ) {
      image = `<img src="${e( store.image )}" alt="${e( store.title )}">`;
    }
    let template = `
    <div class="map-info-popup">
      <div class="map-info-popup__header">
      ${image}${flags}
      </div>
      <div class="map-info-popup__body">
        <p class="map-info-popup__title">${store.title}</p>
        <address>${address}</address>
        <a href="${e( store.detailURL )}" class="btn btn-sm btn-primary">Prodejna <span class="fas fa-arrow-right"></span></a>
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
    [...cards].forEach( elem => {
      elem.querySelector( this.cardListMapButtonSelector ).addEventListener( "click", this.showPopupByStoreId.bind( this ) );
    } );
  }

  /**
   * Show info popup by store ID
   * @param {*} e 
   */
  showPopupByStoreId( e ) {
    e.preventDefault();
    const marker = this.getMarkerByStoreId( e.currentTarget.dataset.storeid );

    if( this.enableClusters ){
      this.markerGroup.zoomToShowLayer( marker, () => {
        setTimeout( () => { marker.openPopup(); }, 500 );
      } );
    } else {
      const markerBounds = L.latLngBounds( [ marker.getLatLng() ] );
      this.map.fitBounds( markerBounds );
      marker.openPopup();
    }
    
    this.mapContainer.scrollIntoView( { behavior: "smooth" } );
  }

  /**
   * Find marker by store ID
   */
  getMarkerByStoreId( storeId ) {
    let marker;
    this.markerGroup.eachLayer( layer => {
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
