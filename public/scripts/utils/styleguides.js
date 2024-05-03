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
  
  // Maps
  if( $( "#allstores_map").length > 0 ) {
    new UTILS.MultiMap( document.querySelector( "#allstores_map" ) );
  }

  [ ...document.querySelectorAll( ".store-detail__map" ) ].forEach( function( el ) { new UTILS.SimpleMap( el ); } )  ;

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