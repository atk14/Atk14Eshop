window.UTILS = window.UTILS || { };

window.UTILS.initBasketOverviewDropdown = function() {
  var $ = window.jQuery;
  var $this = this;

  this.onBasketLoad = function( e ) {
    console.log( "got content" );
  }

  this.loadBasketContent = function( e ){
    console.log( e, "opening popup" );
    var basketDropdown = $( this ).find( ".js--basket-overview-popup" );
    basketDropdown.find( ".basket-overview-popup__content" ).html( "prd" );
    //basketDropdown.addClass( "basket-overview-popup--loading" );
    basketDropdown.attr( "data-status", "loading" );
    //basketDropdown.removeClass( "basket-overview-popup--empty" );*/
    //dropdown.css( "outline", "2.5mm solid red");
    setTimeout( $this.onBasketLoad, 500 )
  };

  $( ".js--basket-overview-popup-container" ).on( "show.bs.dropdown", $this.loadBasketContent );
  
};

window.UTILS.initBasketOverviewDropdown();