/* eslint-disable no-unused-vars */

//import { GestureHandling } from "leaflet-gesture-handling";

export class MapBase {
  L = null;
  static librariesLoaded = false;
  constructor() {
    console.log( "MapBase constructor" );
    //this.loadLeaflet();
  }

  async loadLeaflet() {
    try {
      let leaflet = await import( "leaflet/dist/leaflet-src.esm.js" );
      this.L = leaflet;
      var L = leaflet;
      window.L = leaflet;
      //import { GestureHandling } from "leaflet-gesture-handling";
      await import ("leaflet-gesture-handling");
      console.log( "Leaflet loaded? ...", leaflet );
      this.librariesLoaded = true;
    }
    catch( error ) {
      console.error( "Error loading Leaflet", error);
    }
  }

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
}

export class SimpleMap extends MapBase {
  mapElement;
  lat;
  lng;
  zoom;
  title;
  map;
  marker;
  baseMapLayer;
  constructor( mapElement ) {
    super();
    if( !this.librariesLoaded ) {
      this.loadLeaflet().then( () => {
        console.log( "MapTest constructor - loading libraries" );
        this.createMap( mapElement );
      });
    } else {
      console.log( "MapTest constructor - libraries already loaded" );
      this.createMap( mapElement );
    }
    
    //this.createMap( document.querySelector( "#store-map" ) );
  }
  createMap( mapElement ) {
    console.log( "MapTest createMap" );
    this.mapElement = mapElement;
    this.lat = mapElement.dataset.lat;
    this.lng = mapElement.dataset.lng;
    this.zoom = mapElement.dataset.zoom;
    this.title = mapElement.dataset.title;
    let L = window.L;

    // Create basemap tile layer
    this.baseMapLayer = L.tileLayer( MapBase.mapProvider, { 
      attribution: MapBase.mapAttribution 
    } );

    // Create map
    this.map = L.map( this.mapElement, {
      center: [ this.lat, this.lng ],
      zoom: this.zoom,
      gestureHandling: true,
      layers: [ this.baseMapLayer ],
    } );

    // Add marker
      this.marker = L.marker( [this.lat, this.lng], { icon: L.icon( MapBase.iconOptions ) } ).addTo( this.map );
      if( this.title ) {
        this.marker.bindPopup( this.title );
      }
  
      // Add provider logo if required
      MapBase.addTileProviderLogo( this.map );
  }
}