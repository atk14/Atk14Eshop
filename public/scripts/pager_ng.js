if ( !window.ATK14COMMON ) {
		window.ATK14COMMON = {};
	}
	var ATK14COMMON = window.ATK14COMMON;

  ATK14COMMON.PagerNG = class {

    pager;
    list;
    buttons;
    remains;
    offsetName = "offset";
    limitName = "count";
    pagerName = "pager";

    constructor( element ) {
      console.log( "Creating pager NG: " + element );

      this.pager = element;

      // copy pager data from data attribute to this object
      Object.assign( this, JSON.parse( this.pager.dataset.pager ) );

      this.reinit();

    }

    static init ( selector ) {
      const elements = document.querySelectorAll( selector );
      for ( const element of elements ) {
        //new ATK14COMMON.PagerNG( element );
        console.log( "Initializing pager NG: " + element );
        if( element.ajaxPagerNG ) {
          console.log( "Pager NG exists: " , element.ajaxPagerNG );
          element.ajaxPagerNG.reinit();
        } else {
          element.ajaxPagerNG = new ATK14COMMON.PagerNG( element );
          console.log( "Pager NG initialized: " , element.ajaxPagerNG );
        }
      }
    }

    reinit () {
      console.log( "Reinitializing pager NG: " );

      this.list = this.pager.querySelector( ".js--pager-list" );
			this.buttons = {
				first: 		this.pager.querySelector( ".js--first" ),
				previous: this.pager.querySelector( ".js--previous" ),
				next: 		this.pager.querySelector( ".js--next" )
			};
			this.remains = this.pager.querySelector( ".js--remains" );

			Object.keys( this.buttons ).forEach( ( function( key ) {
				let button = this.buttons[ key ];
				button.pager_role = key;
				this.buttonize( button, key );
			} ).bind( this ) );

			this.updateCount();
			this.updateNextButton();

      // TODO form
    }



    buttonize ( button, role ) {

    }

    updateCount () {
      this.count = parseInt( this.pager.dataset.count );
    }

    updateNextButton () {

    }

  }

  ATK14COMMON.PagerNG.init( ".ajax_pager" );