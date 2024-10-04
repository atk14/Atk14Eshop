/**
 * 
 * 
 */

window.UTILS = window.UTILS || { };

window.UTILS.LiveStatusRefresher = class {
  lang;
  reqInitObject;
  constructor() {
    this.lang = document.querySelector( "html" ).getAttribute( "lang" );
    const reqHeader = new Headers();
    reqHeader.append('X-Requested-With', 'XMLHttpRequest');
    this.reqInitObject = {
      method: 'GET', headers: reqHeader,
    };
    window.addEventListener( "basket_remote_updated", this.updateBasketInfo.bind( this ) );
  }
  async updateBasketInfo() {
    console.log( "updateBasketInfo" );
    const response = await fetch( "/" + this.lang + "/baskets/get_basket_info", this.reqInitObject );
    const content = await response.text();
    console.log(content);
    this.render( ".js--basket_info_content", content );
  }
  updateFavouritesInfo() {

  }

  render ( selector, content ) {
    const containers = document.querySelectorAll( selector );
    [...containers].forEach( function( el ) {
      console.log( el );
      el.innerHTML = content;
    }.bind( this ) );
  }
};