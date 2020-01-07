( function( window, undefined ) {
	"use strict";

	var $ = window.jQuery;
	if ( !window.ATK14COMMON ) {
		window.ATK14COMMON = {};
	}
	var ATK14COMMON = window.ATK14COMMON;

	ATK14COMMON.Pager = function( $element ) {
		if ( $element.pagerInited ) { return; }
		$element.pagerInited = this;
		this.$pager = $( $element );
		this.$list = this.$pager.find( ".js--pager-list" );
		this.offsetName = "offset";
		this.limitName = "count";
		this.pagerName = "pager";

		$.extend( this, this.$pager.data( "pager" ) );
		this.updateCount();

		this.$buttons = {
			first: this.$pager.find( ".js--first a" ),
			previous: this.$pager.find( ".js--previous a" ),
			next: this.$pager.find( ".js--next a" )
		};
		this.remains = this.$pager.find( ".js--remains" );

		Object.keys( this.$buttons ).forEach( ( function( key ) {
			var $button = this.$buttons[ key ];
			$button.pager_role = key;
			this.buttonize( $button, key );
		} ).bind( this ) );

		this.updateNextButton();

		$( window ).on( "popstate",
		    ( function( ) { this.doPaging( document.location.href ); } ).bind( this )
		);

		if ( this.form ) {
			this.$form = $( "#" + this.form );

			this.$form.find( "select" ).change( ( function() {
				this.$form.submit();
			} ).bind( this ) );

			this.$form.submit( ( function( e ) {
					$.ajax( {
						 type: "post",
						 url: this.$form.attr( "action" ),
						 data: this.$form.serialize(),
						 dataType: "json",
						 success: ( function( data ) {
							 this.updatePager( data, { noScroll: true } ) ;
							} ).bind( this )
					 } );
				e.preventDefault();
				return false;
				}
				).bind( this ) );
		}
	};

	ATK14COMMON.Pager.init = function() {
		$( ".ajax_pager" ).each( function( k, $e ) { new ATK14COMMON.Pager( $e ); } );
	};

	ATK14COMMON.Pager.prototype.updateCount = function() {
			this.count = this.$list.find( ".js--pager-item" ).length;
	};

	ATK14COMMON.Pager.prototype.getText = function( text ) {
		var add = [ text ] ;
		var replace = [] ;
		var char = "s".charCodeAt( 0 );

		for ( var i = 1; i < arguments.length ; i++ )  {
			var amount = arguments[ i ];
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

		var gname;
		for ( i = add.length ; i > 0 ; i-- ) {
			gname = add.join( "/" );
			if ( this.texts[ gname ] ) {
				gname = this.texts[ gname ];
				for ( var j = 0; j < replace.length ; j++ ) {
					gname = gname.replace( replace[ j ].search, replace[ j ].replace );
				}
				return gname;
			}
			if ( i === 1 ) { break; }
			add[ i - 1 ] = "";
		}

		return gname;
	};

	ATK14COMMON.Pager.prototype.buttonize = function( button, key ) {
		button.on( "click", ( function() { return this.click( button ); } ).bind( this ) );
		button.name = key;
	};

	/* Add params to url, that are greater than 0 */
	ATK14COMMON.Pager.prototype.addToUrl = function( url, param ) {
		var addParam = {};
		if ( param.offset > 0 ) {
			addParam[ this.offsetName ] = param.offset;
		}
		if ( param.limit > 0 && param.limit !== this.pageSize ) {
			addParam[ this.limitName ] = param.limit;
		}
		if ( param.pager ) {
			addParam[ this.pagerName ] = 1;
		}
		addParam = $.param( addParam );
		if ( !addParam ) {
			return url;
		}
		var index = url.indexOf( "?" ), add = index === -1 ? "?" : "&";
		if ( url.indexOf( "//" ) === -1 ) {
			var href = window.location.href;
			var i = href.indexOf( "/", href.indexOf( "/" ) + 2 );
			url = href.substr( 0, i ) + url;
		}
		return url + add + addParam;
	};

	ATK14COMMON.Pager.prototype.updateButton = function( button, url, text, amount ) {
		button.attr( "href", url );
		button.toggleClass( "disabled", !url );
		if ( text ) {
			button.html( this.getText( text, amount ) );
			button.restoreText = null;
		}
	};

	ATK14COMMON.Pager.prototype.updateNextButton = function() {
		var url, text;
		var remain = this.total - this.offset - this.count;

		if ( remain <= 0 ) {
			url = ""; text = "next_page";
			remain = undefined;
		} else if ( this.count + this.pageSize > this.sectionSize ) {
			text = "next_page";
			url = this.addToUrl( this.url, { offset: this.offset + this.count,
			                                 limit: this.newPageSize() } );
			remain = undefined;
		} else {
			text = "next";
			url = this.addToUrl( this.url, { offset: this.offset + this.count } );
			remain = Math.min( remain, this.pageSize );
		}
		this.updateButton( this.$buttons.next, url, text, remain );
	};

	/*Return number of items on previous/next paxe */
	ATK14COMMON.Pager.prototype.newPageSize = function() {
		return this.pagingPer === "section" ? this.sectionSize : this.pageSize ;
	};

	ATK14COMMON.Pager.prototype.updatePager = function( data, options ) {
		if ( data.pageSize ) {
			this.pageSize = data.pageSize;
		}
		if ( data.offset !== this.offset + this.count ||
			   data.count + this.count > this.sectionSize ||
				 data.forceReplace
			 ) {
			this.$list.html( data.items );
			this.offset = data.offset;
			this.count = data.count;

			if ( options.addToHistory  ) {
				window.history.pushState(
					{}, "",
					this.addToUrl( this.url, { offset: this.offset, limit: this.count } )
				);
			}
			if ( !options.noScroll ) {
				var $el = this.$pager.find( "a[name=" + this.pagerName + "_top_href]" );
				$( "html,body" ).animate( { scrollTop: $el.offset().top }, "slow" );
			}
		} else {
			this.$list.append( data.items );
			this.count += data.count;

			if ( options.addToHistory ) {
				window.history.replaceState(
					{}, "",
					this.addToUrl( this.url, { offset: this.offset, limit: this.count } )
				);
			}
		}

		this.updateButton( this.$buttons.first, this.offset ? this.url : null );
		var pSize = this.newPageSize();
		this.updateButton( this.$buttons.previous, this.offset > this.sectionSize ?
				this.addToUrl( this.url, { offset: this.offset - pSize, limit: pSize } ) : "" );
		this.updateNextButton();
		this.updateRemains();
	};

	ATK14COMMON.Pager.prototype.updateRemains = function() {
		var remain = this.total - this.offset - this.count;
		var text;

		if ( remain ) {
			text = this.getText( "remain", remain, this.total );
		}
		this.remains.html( text );
	};

	ATK14COMMON.Pager.prototype.click = function( button ) {
		  var href = button.attr( "href" );
			if ( !href ) {
				return false; }
			button.restoreText = button.html();
			button.html( this.getText( "loading" ) );
			this.doPaging( href, button );
			return false;
	};

	ATK14COMMON.Pager.prototype.doPaging = function( href, button ) {
			$.ajax( {
				url:     this.addToUrl( href, { "pager": 1 } ),
				success: ( function( data ) {
							this.updatePager( data, { addToHistory: button } );
							} ).bind( this ),
				complete: function( ) {
					if ( button && button.restoreText ) {
						button.html( button.restoreText );
						button.restoreText = undefined;
					}
				},
				dataType: "json"
			} );
	};

	$( function() {
		ATK14COMMON.Pager.init();
	} );

} )( this );
