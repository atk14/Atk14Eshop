/**
 * Class for live updating basket and favoutrites statuses when they change in another open tab or window.
 * Works with WindowSync.
 * Listens to basket_remote_updated and favourites_remote_updated events on window object.
 * 
 * Usage:
 * new UTILS.WindowSync();				
 * new UTILS.LiveStatusRefresher();
 * 
 */

window.UTILS = window.UTILS || { };

window.UTILS.LiveStatusRefresher = class {
  lang;
  reqInitObject;
  constructor() {
    this.lang = document.querySelector( "html" ).getAttribute( "lang" );
    const reqHeader = new Headers();
    reqHeader.append( "X-Requested-With", "XMLHttpRequest");
    this.reqInitObject = {
      method: "GET", headers: reqHeader,
    };
    window.addEventListener( "basket_remote_updated", this.updateBasketInfo.bind( this ) );
    window.addEventListener( "favourites_remote_updated", this.updateFavouritesInfo.bind( this ) );
  }
  async updateBasketInfo() {
    console.log( "updateBasketInfo" );
    const response = await fetch( "/" + this.lang + "/baskets/get_basket_info", this.reqInitObject );
    const content = await response.text();
    console.log(content);
    this.render( ".js--basket_info_content", content );
  }
  async updateFavouritesInfo() {
    console.log( "updateFavouritesInfo" );
    const response = await fetch( "/" + this.lang + "/favourite_products/get_favourites_info", this.reqInitObject );
    const content = await response.text();
    console.log(content);
    this.render( ".js--header-favourites", content );
  }

  render ( selector, content ) {
    const containers = document.querySelectorAll( selector );
    [...containers].forEach( function( el ) {
      console.log( el );
      el.innerHTML = content;
    }.bind( this ) );
  }
};