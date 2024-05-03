window.UTILS = window.UTILS || { };

window.UTILS.initSimpleMap = function( mapElemId ) {

	// Init simple map with marker
	// Parameter mapElemId is id of map HTML element (without #)
	// HTML element has attributes id, data-lat, data-lng, data-zoom
	// <div id="mymap" data-lat="50.0770708" data-lng="14.4862577" data-zoom="16">

	// Declare some global vars so eslint won`t insult you
	/* global SMap */
	/* global JAK */

	var $ = window.jQuery; 

	var lat =				$( "#" + mapElemId ).data( "lat" );
	var lng = 			$( "#" + mapElemId ).data( "lng" );
	var initZoom = 	$( "#" + mapElemId ).data( "zoom" );
	var title =			$( "#" + mapElemId ).data( "title" );
	var markerSrc = "/public/dist/images/map-marker-red.svg";

	var stred = SMap.Coords.fromWGS84( lng, lat );
	var mapa = new SMap( JAK.gel( mapElemId ), stred, initZoom );
	mapa.addDefaultLayer( SMap.DEF_BASE ).enable();

	var mouse = new SMap.Control.Mouse( SMap.MOUSE_ZOOM + SMap.MOUSE_PAN );
	mapa.addControl( mouse );

	var zoom = new SMap.Control.Zoom();
	mapa.addControl( zoom );

	var sync = new SMap.Control.Sync();
	mapa.addControl( sync );

	var layer = new SMap.Layer.Marker();
	mapa.addLayer( layer );
	layer.enable();

	var options = {
		url: markerSrc,
		anchor: { left: 15, bottom: 0 },
		title: title
	};
	var marker = new SMap.Marker( stred, "myMarker", options );
	layer.addMarker( marker );
};

window.UTILS.initMultiMap = function( mapElemId ) {
	// Init map with multiple markers
	// Parameter mapElemId is id of map HTML element (without #)

	// Declare some global vars so eslint won`t insult you
	/* global SMap */
	/* global JAK */
	/* global storeLocatorData */
	/* global storeLocatorBounds */

	var $ = window.jQuery;
	// console.log( "initMultiMap", mapElemId );
	
	var markerSrc = "/public/dist/images/map-marker-red.svg";
	var storeData = storeLocatorData;
	var markers = new Array();
	var cards = new Array();
	var positions = new Array();
	var storeCardsContainer = $( ".js-stores-cards" );
	var storeCards = $( ".js-stores-cards .js-store-item");
	var mapContainer = $( "#" + mapElemId );
	var enableClusters = mapContainer.data( "enable_clusters" );
	var clusterDistance = mapContainer.data( "cluster_distance" );
	var centerZoom;

	// Init mapy
	var stred = SMap.Coords.fromWGS84( 14.4234447, 50.0736203 );
	var mapa = new SMap( JAK.gel( mapElemId ), stred, 10 );
	mapa.addDefaultLayer( SMap.DEF_BASE ).enable();

	var mouse = new SMap.Control.Mouse( SMap.MOUSE_ZOOM + SMap.MOUSE_PAN );
	mapa.addControl( mouse );

	var zoom = new SMap.Control.Zoom();
	mapa.addControl( zoom );

	var sync = new SMap.Control.Sync();
	mapa.addControl( sync );

	var markerLayer = new SMap.Layer.Marker();
	mapa.addLayer( markerLayer );
	markerLayer.enable();
	
	var onMapLoaded = function(){

		// Tiles are loaded - remove listener and preloader
		signalLoaded.removeListener( loadListenerId );
		var preloader = document.getElementById( "stores-index__maploader" );
		if( preloader ){
			preloader.remove();
		}
	}
	
	// Listen to when tiles are loaded
	var signalLoaded = mapa.getSignals();
	var loadListenerId = signalLoaded.addListener( window, "tileset-load", onMapLoaded );

	// Urcit posun markeru, pokud je na stejnem miste, jako nejaky jiny
	// (stejnost na 3 desetinna mista)
	for ( var i = 0; i < storeData.length; i++ ) {
		var iLat = Number( Math.round( storeData[ i ].lat + "e3" ) + "e-3" );
		var iLng = Number( Math.round( storeData[ i ].lng + "e3" ) + "e-3" );
		storeData[ i ].markerOffset = 0;
		for ( var j = 0; j < i; j++ ) {
			var jLat = Number( Math.round( storeData[ j ].lat + "e3" ) + "e-3" );
			var jLng = Number( Math.round( storeData[ j ].lng + "e3" ) + "e-3" );
			if ( iLat === jLat && iLng === jLng ) {
				storeData[ i ].markerOffset++;
			}
		}
	}

	// Rozmistit markery
	for ( var i = 0; i < storeData.length; i++ ) {
		var id = storeData[ i ].id;

		// Obsah karty ("vizitka") v mape
		var cardHeader = "<img src=\"" + storeData[ i ].image;
		cardHeader += ( "\" alt=\"" + storeData[ i ].title + "\">" );
		
		if( storeData[ i ].isOpen !== false && typeof( storeData[ i ].isOpen ) === "string" ){
			cardHeader += "<div class=\"flags\"><span class=\"badge badge-success\">" + storeData[ i ].isOpen + "</span></span>";
		}

		var cardBody = "<div><p class=\"card-title\">" + storeData[ i ].title + "</p>";
		cardBody += "<address>" + decodeURIComponent( storeData[ i ].address ) + "</address></div>";
		cardBody += "<a href=\"" + storeData[ i ].detailURL;
		cardBody += "\" class=\"btn btn-sm btn-primary\">";
		cardBody += "Prodejna <span class=\"fas fa-arrow-right\"></span></a>";

		var cardFooter = "";

		// Vytvoreni karty / vizitky
		var card = new SMap.Card( 355 );
		//card.setSize( 355, 143 );
		card.setSize( 355, 200 );
		card.getHeader().innerHTML = cardHeader;
		card.getBody().innerHTML = cardBody;
		card.getFooter().innerHTML = cardFooter;
		card.getBody().style.height = "140px";
		cards.push( card );

		var markerOptions = {
			url: markerSrc,
			anchor: { left: 15, bottom: 0 },
			title: storeData[ i ].title,
		};

		// Offset - posun anchoru markeru u markeru se stejnou polohou
		if ( storeData[ i ].markerOffset > 0 ) {
			var markerOptions = {
				url: markerSrc,
				anchor: { left: -8 * ( storeData[ i ].markerOffset ), bottom: 0 }
			};
		}

		// Vytvoreni markeru a pripojeni vizitky
		var pos = SMap.Coords.fromWGS84( storeData[ i ].lng, storeData[ i ].lat );
		positions.push( pos );
		markers.push( new SMap.Marker( pos, "storeMarker_" + id, markerOptions ) );
		markers[ i ].decorate( SMap.Marker.Feature.Card, card );
	}

	// Add markers to map
	markerLayer.addMarker( markers );

	// Klik na marker
	mapa.getSignals().addListener( this, "marker-click", function( e ) {
		var marker = e.target;

		try {
	
			var id = marker.getId();
			var numId = parseInt( id.split( "_" )[ 1 ] );

			// Checknout velikost viewportu a nastavit velikost karty
			var screenWidth = $( window ).width();

			// Neumime se dostat k jedne karte, tak musime u vsech
			for ( var i = 0; i < cards.length; i++ ) {
				if ( screenWidth < 400 ) {
					cards[ i ].setSize( 300, 167 );
				} else {
					cards[ i ].setSize( 355, 143 );
				}
			}

			// Obarvit aktivni kartu v seznamu pod mapou
			storeCards.removeClass( "active" );
			storeCardsContainer.find( ".js-store-item[data-storeid=" + numId + "]" ).addClass( "active" );
		}
		catch ( err ) {
	
			// Check if we clicked on cluster
			if( marker._clusterOptions ){

				// Close open card in tha map and deactivate list item
				var cardCloser = mapContainer.find( " .card .close" );
				cardCloser.trigger( "click" );
				storeCards.removeClass( "active" );
			} 
		}
	} );

	// Klik na kartu pod mapou - triggerujeme klik na prislusny marker na mape
	storeCards.find( ".js-store-mapbtn" ).on( "click", function( e ) {
		e.preventDefault();
		var id = $( this ).data( "storeid" );
		var marker = null;
		for ( var i = 0; i < markers.length; i++ ) {
			var mid = markers[ i ].getId();
			if ( "storeMarker_" + id === mid ) {
				marker = markers[ i ];
			}
		}
		if( marker ){
			marker.click();
			//scroll na mapu
			mapa.setCenterZoom( marker.getCoords(), 14 );
			mapa.setCenter( marker.getCoords() );
			//$( "html, body" ).animate( { scrollTop: mapContainer.offset().top }, 500 );
			
		}
	} );

	// Zavreni karty / vizitky - odbarvit aktivni kartu
	mapa.getSignals().addListener( this, "card-close-click", function() {
		$( ".store-item" ).removeClass( "active" );
	} );
	
	
	if( typeof storeLocatorBounds !== "undefined" ) {

		// If map bounds in storeLocatorBounds are defined, we use them to calculate center and zoom
		var bounds = new Array();
		for ( var i = 0; i < storeLocatorBounds.length; i++ ) {
			bounds.push( SMap.Coords.fromWGS84( storeLocatorBounds[ i ].lng, storeLocatorBounds[ i ].lat ) );
		};
		centerZoom = mapa.computeCenterZoom( bounds );
	} else {

		// Calculate map center zoom from markers. Fails when there are more than tens of markers
		centerZoom = mapa.computeCenterZoom( positions );
	}

	mapa.setCenterZoom( centerZoom[ 0 ], centerZoom[ 1 ] );

	// Clustering
	if( enableClusters ) {

		// We want clusters to have all the same size
		// https://napoveda.seznam.cz/forum/threads/71496/1  http://jsfiddle.net/592sxtco/6/ 
		var radius = function() { return 18; }

		var MyCluster = function( id ) {
			SMap.Marker.Cluster.call( this, id, { radius:radius } );
			// this._dom.content.style.backgroundColor = "red";
			// this._dom.circle.style.borderRadius = 0;
		};
		MyCluster.prototype = Object.create( SMap.Marker.Cluster.prototype );

		// set clustering mode depending on zoom
		// https://napoveda.seznam.cz/forum/threads/65610/1#aid-109404
		var isCloseView = function ( zoom ) {
			return zoom >= 17
		}

		var setClustering = function setClustering( closeView ) {
			markerLayer.setClusterer( closeView ? null : new SMap.Marker.Clusterer( mapa, clusterDistance, MyCluster ) );
		}
		var lastZoom = mapa.getZoom();
		setClustering( isCloseView( lastZoom ) );
		mapa.getSignals().addListener( window, "map-redraw", function ( e ) {
			var zoom = e.target.getZoom();
			if ( zoom !== lastZoom && isCloseView( zoom ) !== isCloseView( lastZoom ) ) { // closeView treshold crossed
				setClustering( isCloseView( zoom ) );
			}
			lastZoom = zoom;
		})
	}
	
};
