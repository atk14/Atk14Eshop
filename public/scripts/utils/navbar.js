/**
 * Navbar utilities - hoverable dropdowns, mobile search toggle
 */

window.UTILS = window.UTILS || { };

window.UTILS.initNavbar = function() {

  var $dropdown = $( ".dropdown" );
  var $dropdownToggle = $( ".dropdown-toggle" );
  var $dropdownMenu = $( ".dropdown-menu" );
  var showClass = "show";
  var $navbar = $( ".navbar--hoverable-dropdowns" );

  // Navbar dropdowns work on mouseover
  if( $navbar.length ) {
    $navbar.find( $dropdownToggle ).on( "click touchstart", function( e ){
      location.href = $( this ).attr( "href" );
      e.stopImmediatePropagation();
      return false;
    } );
    $navbar.find( $dropdown ).on ( "mouseenter", function( e ) {
        //console.log( e.type );
        e.stopImmediatePropagation();
        var $this = $( this );
        if ( !$this.is( ":hover" ) ) {
          return;
        }
        $this.addClass( showClass );
        $this.find( $dropdownToggle ).attr("aria-expanded", "true");
        $this.find( $dropdownMenu ).addClass( showClass ).hide().fadeIn( 200, function() {
          if ( !$this.is( ":hover" ) ) {
            $this.removeClass( showClass );
            $this.find( $dropdownToggle ).attr( "aria-expanded", "false" );
            $this.find( $dropdownMenu ).removeClass( showClass ).hide();
          }
        } );
    } );
    $navbar.find( $dropdown ).on ( "mouseleave", function() {
        var $this = $(this);
        $this.removeClass( showClass );
        $this.find( $dropdownToggle ).attr( "aria-expanded", "false" );
        $this.find( $dropdownMenu ).removeClass( showClass ).hide();
    } );
  }

  // Mobile search show/hide toggle
  $( ".js--search-toggle" ).on( "click", function( e ) {
    e.preventDefault();
    var $form = $( "#js--mobile_search_field" );
    $form.toggleClass( "show" );
    if( $form.is( ":visible" ) ) {
      $form.find( "input[type=text]" ).focus();
    }
  } );

};