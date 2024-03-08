window.UTILS = window.UTILS || { };

/**
 * Javascript for styleguides
 */

window.UTILS.initStyleguides = function() {
  var $ = window.jQuery;
  var UTILS = window.UTILS;
  $( ".styleguide-color-swatches .color-swatch" ).each( function( i, el ) {
    var swatch = $( el );
    var color = swatch.find( ".color-swatch__patch" ).css( "background-color" );
    swatch.find( ".color-swatch__value" ).text( "#" + UTILS.rgb2hex( color ).toUpperCase() );
  } );
  
  // Tlacitka +/- mnozstvi pri pridani do kosiku
  var qtyButtons = $( ".js-stepper button[data-spinner-button]" );
  qtyButtons.on( "click", function( e ) {
    e.preventDefault();
    var qtyWidget = $( this ).closest( ".js-stepper" );
    var qtyInput = qtyWidget.find( ".js-order-quantity-input" );
    var oldValue = parseInt( qtyInput.val() );
    var qtyMin = parseInt( qtyInput.attr( "min" ) );
    var qtyMax = parseInt( qtyInput.attr( "max" ) );
    var qtyStep = parseInt( qtyInput.attr( "step" ) );
    var newValue;
    if( $( this ).attr( "data-spinner-button" ) === "up" ){
      newValue = Math.min( qtyMax, oldValue + qtyStep );
    } else {
      newValue = Math.max( qtyMin, oldValue - qtyStep );
    }
    qtyInput.val( newValue );
    qtyInput.trigger( "change" );
  } );
  
  // Maps
  if( $( "#allstores_map").length > 0 ) {
    UTILS.initMultiMap( "allstores_map" );
  }
  if( $( "#store-map").length > 0 ) {
    UTILS.initSimpleMap( "store-map" );
  }

  // List tree collapse all/expand all toggle
  $( ".js-toggle-all-trees" ).on( "click", function() {
    if( $( this ).hasClass( "collapsed" ) ){
      $( ".list--tree.collapse" ).collapse( "show" );
    } else {
      $( ".list--tree.collapse" ).collapse( "hide" );
    }
    $( this ).toggleClass( [ "collapsed", "expanded" ] )
  } );

  // TOC search
  // eslint-disable-next-line no-unused-vars
  var storeList = new UTILS.filterableList( {
    searchInput: 	$( "#chapter_filter" ),
    clearButton: 	false,
    submitButton: false,
    listItems:		$( ".js--chapter_toc > *" ),
    searchTextSelector: false,
  } );
};