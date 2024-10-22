/**
 * Class for live updating basket and favoutrites statuses when they change in another open tab or window.
 * In baskets/edit and checkouts/summary screens it launches modal prompting user to reload page
 * Requires WindowSync.
 * 
 * Listens to basket_remote_updated and favourites_remote_updated events on window object (triggered by WindowSync).
 * 
 * Usage:
 * 
 * new UTILS.WindowSync();				
 * new UTILS.LiveStatusRefresher();
 * 
 */

import { Modal } from "bootstrap";

window.UTILS = window.UTILS || { };

window.UTILS.LiveStatusRefresher = class {
  lang = document.querySelector( "html" ).getAttribute( "lang" );
  reqInitObject;
  bodyData = document.querySelector( "body" ).dataset;

  constructor() {

    // get document language
    //this.lang = document.querySelector( "html" ).getAttribute( "lang" );

    // setup headers for xhr requests
    const reqHeader = new Headers();
    reqHeader.append( "X-Requested-With", "XMLHttpRequest");
    this.reqInitObject = {
      method: "GET", headers: reqHeader,
    };

    // listen to WindowSync events
    window.addEventListener( "basket_remote_updated", this.updateBasketInfo.bind( this ) );
    window.addEventListener( "favourites_remote_updated", this.updateFavouritesInfo.bind( this ) );
  }

  async updateBasketInfo() {
    const response = await fetch( "/" + this.lang + "/baskets/get_basket_info", this.reqInitObject );
    const content = await response.text();
    this.render( ".js--basket_info_content", content );

    // Show modal if on baskets/edit or checkouts/summary screen 
    if( ( this.bodyData.controller === "baskets" && this.bodyData.action === "edit" ) || ( this.bodyData.controller === "checkouts" && this.bodyData.action === "summary" ) ) {
      if( window.bootstrapVersion && window.bootstrapVersion === 5 ) {
        // Bootstrap 5
        console.log( "Modal", Modal );
        const basketChangedModal = new Modal(document.getElementById( "modal_basket_changed" ) );
        basketChangedModal.show();
      } else {
        // Bootstrap legacy
        window.jQuery( "#modal_basket_changed" ).modal();
      } 
    }
  }
  
  async updateFavouritesInfo() {
    const response = await fetch( "/" + this.lang + "/favourite_products/get_favourites_info", this.reqInitObject );
    const content = await response.text();
    this.render( ".js--header-favourites", content );
  }

  /** Replaces tag specified by selector with content */
  render ( selector, content ) {
    const containers = document.querySelectorAll( selector );
    [...containers].forEach( function( el ) {
      // Convert string to html node easy way: create node, set its innerHtml, get first child
      let div = document.createElement("div");
      div.innerHTML = content;
      let htmlContent = div.firstChild;
      //replace original content
      el.replaceWith( htmlContent );
    }.bind( this ) );
  }
};