window.UTILS = window.UTILS || { };

window.UTILS.initBasketOverviewDropdown = function() {
  var $ = window.jQuery;
  var $this = this;
  //var basketDropdownInner;

  this.onBasketLoad = function() {
    console.log( "got content" );
    var content = $this.basketDropdownInner.find( ".basket-overview-dropdown__content" );
    // tady bude nahrazeni obsahu kosiku ajax obsahem
    // content.html( "" );
    if ( content.find( ".basket-overview-dropdown__empty" ).length > 0 ) {
      console.log( "basket empty");
      $this.basketDropdownInner.attr( "data-status", "empty" );
    } else {
      console.log( "basket not empty" );
      $this.basketDropdownInner.attr( "data-status", "loaded" );
    }
    // pokud nastane chyba
    // $this.basketDropdownInner.attr( "data-status", "error" );
  }

  this.loadBasketContent = function( e ){
    $this.basketDropdownInner = $( this ).find( ".js--basket-overview-dropdown__inner" );
    //$this.basketDropdownInner.find( ".basket-overview-dropdown__content" ).html( "" );
    $this.basketDropdownInner.attr( "data-status", "loading" );
    // misto timeoutu sem prijde ajax nacteni kosiku
    setTimeout( $this.onBasketLoad, 500 );
  };

  $( ".js--basket-overview-dropdown-container" ).on( "show.bs.dropdown", $this.loadBasketContent );
  
};

window.UTILS.initBasketOverviewDropdown();