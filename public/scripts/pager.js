/**
 * ATK14COMMON.Pager
 *
 * AJAX pager — loads items without a full page reload and updates the browser URL history.
 * Supports two modes: append (load more) and replace (go to page).
 *
 * Initialization:
 *   Runs automatically on all elements with class `.ajax_pager` on DOMContentLoaded.
 *   Manual re-initialization after AJAX re-render: ATK14COMMON.Pager.init( ".ajax_pager" )
 *
 * Required HTML structure:
 *
 *   <div class="ajax_pager" data-pager='{...}' data-count="12">
 *     <div class="js--pager-list">
 *       <!-- items -->
 *     </div>
 *     <a class="js--first"    href="...">First</a>
 *     <a class="js--previous" href="...">Previous</a>
 *     <a class="js--next"     href="...">Load more</a>
 *     <span class="js--remains"></span>
 *   </div>
 *
 * Configuration (JSON in data-pager attribute):
 *   url          {string}  Base URL for AJAX requests
 *   offset       {number}  Index of the first currently displayed item
 *   count        {number}  Number of currently displayed items
 *   pageSize     {number}  Number of items to load on next click
 *   sectionSize  {number}  Maximum items per section (exceeding triggers replace instead of append)
 *   total        {number}  Total number of items
 *   texts        {object}  Localized button and counter strings
 *   form         {string}  ID of the filter form (optional)
 *   pagingPer    {string}  "section" = page by section size, otherwise by pageSize (optional)
 *
 * Events (dispatched on the .ajax_pager element, bubbles: true):
 *   pager:loading            Fired before the AJAX request is sent
 *   pager:updated  {detail}  Fired after new content is inserted into the DOM
 *     detail.offset          Current offset after update
 *     detail.count           Number of currently displayed items
 *     detail.total           Total number of items
 *     detail.forceReplace    Whether content was replaced (true) or appended (false)
 *
 * Event handling examples:
 *   document.querySelector( ".ajax_pager" ).addEventListener( "pager:updated", ( e ) => {
 *     // initialize widgets on newly loaded items
 *   } );
 *   
 *   document.addEventListener( "pager:updated", ( e ) => {
 *    console.log( `Pager updated: Loaded ${e.detail.count} items, total ${e.detail.total}` );
 *  } );
 * 
 * Note: This is a simplified version of the original pager.js, refactored to use modern JavaScript features and remove jQuery dependency.
 */

if ( !window.ATK14COMMON ) {
		window.ATK14COMMON = {};
	}
	var ATK14COMMON = window.ATK14COMMON;

  ATK14COMMON.Pager = class {

    pager;
    list;
    buttons;
    remains;
    offsetName = "offset";
    limitName = "count";
    pagerName = "pager";

    constructor( element ) {
      this.pager = element;

      // copy pager data from data attribute to this object
      Object.assign( this, JSON.parse( this.pager.dataset.pager ) );

      this.reinit();

      if ( !this.list ) {
        console.warn( "AjaxPager:", "List not found. Set class 'js--pager-list' to proper element");
        return;
      }

      window.addEventListener( "popstate", () => {
        this.doPaging( window.location.href, undefined, { noScroll: true } );
      } );

    }

    static init ( selector ) {
      const elements = document.querySelectorAll( selector );
      for ( const element of elements ) {
        if ( element.ajaxPager ) {
          element.ajaxPager.reinit();
        } else {
          element.ajaxPager = new ATK14COMMON.Pager( element );
        }
      }
    }

    reinit () {
      this.list = this.pager.querySelector( ".js--pager-list" );
			this.buttons = {
				first: 		this.pager.querySelector( ".js--first" ),
				previous: this.pager.querySelector( ".js--previous" ),
				next: 		this.pager.querySelector( ".js--next" )
			};
			this.remains = this.pager.querySelector( ".js--remains" );

			Object.keys( this.buttons ).forEach( ( key ) => {
				let button = this.buttons[ key ];
				button.pager_role = key;
				this.buttonize( button, key );
			} );

			this.updateCount();
			this.updateNextButton();

      if ( this.form ) {
        this.formElement = document.getElementById(this.form);

        if (this.formElement && !this.formElement.pagerInited) {
          const pagingForm = document.getElementById("paging_form");
          if (pagingForm) {
            pagingForm.addEventListener("click", (e) => {
              e.preventDefault();
              if (e.target.tagName.toUpperCase() !== "A") {
                return;
              }

              const a = e.target;
              const form = pagingForm.querySelector("form");
              const li = a.parentElement;

              li.parentElement.querySelectorAll(":scope > *").forEach(el => el.classList.remove("active"));
              li.classList.add("active");

              if (form && form.dataset.remote) {
                const filterForm = document.getElementById("filter_form");
                form.setAttribute("action", a.getAttribute("href"));
                if (filterForm) {
                  filterForm.setAttribute("action", a.dataset.filterHref);
                  filterForm.filtering = (filterForm.filtering || 0) + 1;
                }
                form.submit();
              } else {
                window.location.href = a.getAttribute("href") + "#pager";
              }
            });
          }

          this.formElement.pagerInited = true;
        }
      }
    }



    buttonize ( button, key ) {
      button.addEventListener( "click", ( e ) => {
        e.preventDefault();
        this.click( button );
      } );
      button.name = key;
    }

    /* Add params to url, that are greater than 0 */
    addToUrl( url, param ) {
      let addParam = {};
      if ( param.offset > 0 ) {
        addParam[ this.offsetName ] = param.offset;
      }
      if ( param.limit > 0 && param.limit !== this.pageSize ) {
        addParam[ this.limitName ] = param.limit;
      }
      if ( param.pager ) {
        addParam[ this.pagerName ] = 1;
      }
      addParam = new URLSearchParams( addParam ).toString();
      if ( !addParam ) {
        return url;
      }
      let index = url.indexOf( "?" ), add = index === -1 ? "?" : "&";
      if ( url.indexOf( "//" ) === -1 ) {
        let href = window.location.href;
        let i = href.indexOf( "/", href.indexOf( "/" ) + 2 );
        url = href.substring( 0, i ) + url;
      }
      return url + add + addParam;
    }

    updateCount () {
      this.count = parseInt( this.pager.dataset.count );
    }

    getText( text ) {
      let add = [ text ] ;
      let replace = [] ;
      let char = "s".charCodeAt( 0 );

      for ( let i = 1; i < arguments.length ; i++ )  {
        let amount = arguments[ i ];
        if ( amount <= 0 ) {
          add.push( "0" );
        } else if ( amount > 1 ) {
          add.push( amount > 4 ? "ss" : "s" );
        } else {
          add.push( "" );
        }
        replace.push( { search: "%" + String.fromCharCode( char ), replace: amount } );
        char++;
      }

      let gname;
      for ( let i = add.length ; i > 0 ; i-- ) {
        gname = add.join( "/" );
        if ( this.texts[ gname ] !== undefined ) {
          gname = this.texts[ gname ];
          for ( let j = 0; j < replace.length ; j++ ) {
            gname = gname.replace( replace[ j ].search, replace[ j ].replace );
          }
          return gname;
        }
        if ( i === 1 ) { break; }
        add[ i - 1 ] = "";
      }

      return gname;
    }

    updateButton ( button, url, text, amount ) {
      if ( url ) {
        button.setAttribute( "href", url );
      } else {
        button.removeAttribute( "href" );
      }
      button.classList.toggle( "disabled", !url );
      if ( text ) {
        button.innerHTML = this.getText( text, amount );
        button.restoreText = null;
      }
    }

    updateNextButton () {
      let url, text;
		  let remain = this.total - this.offset - this.count;

      if ( remain <= 0 ) {
        url = ""; text = "next_page";
        remain = undefined;
      } else if ( this.count + this.pageSize > this.sectionSize ) {
        text = "next_page";
        url = this.addToUrl( this.url, {
          offset: this.offset + this.count,
          limit: this.newPageSize()
        } );
        remain = undefined;
        this.buttons.next.classList.add( "next-page" );
        this.buttons.next.classList.remove( "next-items" );
      } else {
        text = "next";
        url = this.addToUrl( this.url, {
          offset: this.offset + this.count
        } );
        remain = Math.min( remain, this.pageSize );
        this.buttons.next.classList.add( "next-items" );
        this.buttons.next.classList.remove( "next-page" );
      }
      this.updateButton( this.buttons.next, url, text, remain );
    }

    /*Return number of items on previous/next paxe */
    newPageSize() {
      return this.pagingPer === "section" ? this.sectionSize : this.pageSize ;
    }

    updatePager( data, options ) {
      if ( data.pageSize ) {
        this.pageSize = data.pageSize;
      }

      const items = [ ...document.createRange().createContextualFragment( data.items ).children ];
      const masonry = this.list.closest( ".masonry" );
      const origOffset = window.scrollY;
      const origOverflowAnchor = document.body.style.overflowAnchor;

      if ( data.paginator ) {
        const paginator = document.querySelector( "#js--ajax_pager__paginator" );
        if ( paginator ) { paginator.outerHTML = data.paginator; }
      }
      
      document.body.style.overflowAnchor = "none";

      if ( data.offset !== this.offset + this.count
        || data.count + this.count > this.sectionSize
        || data.forceReplace ) {

        // Replacing content either of a masonry or a classic list
        if ( this.list.classList.contains( "masonry__items" ) ) {
          masonry.querySelectorAll( ".masonry__item" ).forEach( el => el.classList.add( "d-none" ) );
          $( masonry ).colcade( "prepend", $( items ).filter( ".masonry__item" ) );
          masonry.querySelectorAll( ".masonry__item.d-none" ).forEach( el => el.remove() );
          masonry.querySelectorAll( "input[type='number']" ).forEach( el => $( el ).stepper() );
        } else {
          this.list.replaceChildren( ...items );
        }

        this.offset = data.offset;
        this.count = data.count;

        if ( options.addToHistory ) {
          window.history.pushState( {}, "",
            this.addToUrl( this.url, { offset: this.offset, limit: this.count } )
          );
        }
        if ( !options.noScroll ) {
          const anchor = this.pager.querySelector( `a[id="anchor--${this.pagerName}-top"]` );
          if ( anchor ) { anchor.scrollIntoView( { behavior: "smooth" } ); }
        }

      } else {

        // Appending new items either to a masonry or to a classic list
        if ( this.list.classList.contains( "masonry__items" ) ) {
          masonry.querySelectorAll( ".masonry__item" ).forEach( el => el.classList.add( "custom-marker" ) );
          $( masonry ).colcade( "append", $( items ).filter( ".masonry__item" ) );
          masonry.querySelectorAll( ".masonry__item:not(.custom-marker) input[type='number']" ).forEach( el => $( el ).stepper() );
          masonry.querySelectorAll( ".masonry__item" ).forEach( el => el.classList.remove( "custom-marker" ) );
        } else {
          items.forEach( item => {
            item.style.opacity = "0";
            item.style.transition = "opacity 0.6s";
            this.list.appendChild( item );
            requestAnimationFrame( () => {
              requestAnimationFrame( () => { item.style.opacity = "1"; } );
            } );
          } );
        }

        this.count += data.count;

        // This is a fallback when setting the overflow-anchor doesn't help.
        // There is a small delay to make sure that the Colcade finished its job.
        setTimeout( () => { window.scrollTo( 0, origOffset ); }, 10 );

        if ( options.addToHistory ) {
          window.history.replaceState(
            {}, "",
            this.addToUrl( this.url, { offset: this.offset, limit: this.count } )
          );
        }
      }

      const pSize = this.newPageSize();
      this.updateButton( this.buttons.first, this.offset > this.sectionSize ?
        this.addToUrl( this.url, { limit: this.sectionSize } ) : null
      );
      this.updateButton( this.buttons.previous, this.offset ?
          this.addToUrl( this.url, { offset: this.offset - pSize, limit: pSize } ) : ""
      );
      this.updateNextButton();
      this.updateRemains();

      document.body.style.overflowAnchor = origOverflowAnchor;

      /**
       * Pustime si callback, pokud jsme si ho s daty poslali
       * Pravdepodobne obsolete
       */
      /*if ( data.callback !== undefined ) {
        console.log( "Executing callback: " + data.callback );
        var cb = new Function( "return " + data.callback );
        ( cb() )();
      }*/

      // create and dispatch custom event with pager data
      this.pager.dispatchEvent( new CustomEvent( "pager:updated", {
        bubbles: true,
        detail: {
          offset: this.offset,
          count: this.count,
          total: this.total,
          forceReplace: !!data.forceReplace
        }
      } ) );

    }

    updateRemains () {
      let remain = this.total - this.offset - this.count;
      let text;
      text = this.getText( "remain", remain, this.total );
      this.remains.innerHTML = text;
    }

    click( button ) {
      const href = button.getAttribute( "href" );
      if ( !href ) {
        return; 
      }
      button.restoreText = button.innerHTML;
      this.doPaging( href, button );
    }

    async doPaging ( href, button, updatePagerOptions = {} ) {
			updatePagerOptions.addToHistory = button;
      const url = this.addToUrl( href, { pager: 1 } );

      // create and dispatch custom event before loading new page
      this.pager.dispatchEvent( new CustomEvent( "pager:loading", { bubbles: true } ) );

      try {
        const response = await fetch( url, {
          headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"}
        } );
        if ( !response.ok ) { throw new Error( response.statusText ); }
        const data = await response.json();
        this.updatePager( data, updatePagerOptions );
      } finally {
        if ( button && button.restoreText ) {
          button.innerHTML = button.restoreText;
          button.restoreText = undefined;
        }
      }
			
	  }

  }

  ATK14COMMON.Pager.init( ".ajax_pager" );
