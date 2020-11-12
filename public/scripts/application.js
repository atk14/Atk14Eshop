/* global window */
( function( window, $, undefined ) {
	"use strict";
	var document = window.document,
	UTILS = window.UTILS, // Uncomment this if you need something from UTILS

	APPLICATION = {
		common: {

			// Application-wide code.
			init: function() {
				
				// Init Swiper
				UTILS.initSwiper();

				// Init PhotoSwipe
				UTILS.initPhotoSwipeFromDOM( ".gallery__images, .iobject--picture" );

				// Restores email addresses misted by the no_spam helper
				$( ".atk14_no_spam" ).unobfuscate( {
					atstring: "[at-sign]",
					dotstring: "[dot-sign]"
				} );

				// Links with the "blank" class are pointing to new window
				$( "a.blank" ).attr( "target", "_blank" );

				// Form hints.
				$( ".help-hint" ).each( function() {
					var $this = $( this ),
						$field = $this.closest( ".form-group" ).find( ".form-control" ),
						title = $this.data( "title" ) || "",
						content = $this.html(),
						popoverOptions = {
							html: true,
							trigger: "focus",
							title: title,
							content: content
						};

					$field.popover( popoverOptions );
				} );

				// Navbar dropdowns work on mouseover
				var $dropdown = $( ".dropdown" );
				var $dropdownToggle = $( ".dropdown-toggle" );
				var $dropdownMenu = $( ".dropdown-menu" );
				var showClass = "show";
				var $navbar = $( ".navbar--hoverable-dropdowns" );

				$navbar.find( $dropdownToggle ).on( "click touchstart", function( e ){
					//console.log( e.type );
					location.href = $( this ).attr( "href" );
					//$dropdown.trigger( "mouseleave" )
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
				$navbar.find( $dropdown ).on ( "mouseleave", function( e ) {
						//console.log( e.type );
						var $this = $(this);
						$this.removeClass( showClass );
						$this.find( $dropdownToggle ).attr( "aria-expanded", "false" );
						$this.find( $dropdownMenu ).removeClass( showClass ).hide();
				} );

				// Mobile search show/hide toggle
				$( ".js--search-toggle" ).on( "click", function( e ) {
					e.preventDefault();
					var $form = $( "#js--main_search_field" );
					$form.toggleClass( "d-flex" );
					if( $form.is( ":visible" ) ) {
						$form.find( "input[type=text]" ).focus();
					}
				} );

				// After mobile navbar menu finished collapsing
				// Place search field to its default position in DOM
				$( "#navTopMobileNavDropdown" ).on( "hidden.bs.collapse", function () {
					var $form = $( "#js--main_search_field" );
					$form.detach().prependTo( "#js--main_search_container" );
				})

				// After mobile navbar menu started to expanded
				// Move search field to mobile menu in DOM
				$( "#navTopMobileNavDropdown" ).on( "show.bs.collapse", function () {
					var $form = $( "#js--main_search_field" );
					$form.detach().prependTo( "#navTopMobileNavDropdown" );
				})
				
				// When whole mobile navbar is hidden on resize (at reponsive breakpoint)
				window.addEventListener( "resize", function() {
					
					if( $( ".navbar-top--mobile" ).css( "display" ) === "none" ){

						// Collapse mobile navbar
						if( $( ".navbar-top--mobile .navbar-toggler" ).hasClass( "collapsed" ) !== true ){
							$( ".navbar-top--mobile .navbar-toggler" ).trigger( "click" );
						}
						
						// Place search field to its default position in DOM
						var $form = $( "#js--main_search_field" );
						$form.detach().prependTo( "#js--main_search_container" );
					}
				});
			
				if( $( "body" ).attr( "data-scrollhideheader" ) === "true" ) {
					var prevScroll = document.documentElement.scrollTop || window.scrollY;
					var  direction = "";
					var prevDirection = ""

					var handleHideScroll = function() {
						var currScroll = document.documentElement.scrollTop || window.scrollY;

						if ( currScroll > prevScroll ) {

							// Scrolled up
							direction = "up";
						} else if ( currScroll < prevScroll ) {

							//scrolled down
							direction = "down";
						}

						if ( direction !== prevDirection ) {
							toggleHeader( direction, currScroll );
						}

						prevScroll = currScroll;
					}

					var toggleHeader = function( direction, currScroll ) {
						var header = document.getElementById ( "header-main" );
						var docBody = document.getElementById ( "page-body" );
						var headerHeight = header.offsetHeight;
						if( currScroll > headerHeight + 50 ) {
							
							// Scrolled down
							$( header ).css( "position", "fixed" );
							$( header ).css( "top", ( 0 - headerHeight ) + "px" );
							docBody.style.paddingTop = headerHeight + 40 + "px";
						} else {
							
							// Top
							$( header ).css( "position", "static" );
							$( header ).css( "top", ( 0 - headerHeight ) + "px" );
							docBody.style.paddingTop = 0 + "px";
						}
						if ( direction === "up" && currScroll > headerHeight ) {
							
							// Scrolled down, hidden
							$( header ).css( "top", ( 0 - headerHeight ) + "px" );
							
						} else if ( direction === "down" ) {
							
							// Scrolled down, shown
							$( header ).css( "top", "0px" );
						}
	
						prevDirection = direction;
					};
	
					window.addEventListener( "scroll", handleHideScroll );
					window.addEventListener( "resize", handleHideScroll );
				}

				// Prototyping Search Suggestions
				// TODO: rewrite it to a plugin
				var suggestingCache = {};
				var suggestingAreaVisible = false;
				var suggestingAreaNeedsToBePositioned = true;
				var suggestingAreaOriginalContent;

				var suggest = function( e, field, eve ) {
					var $field = $( field );
					var $form = $field.closest( "form" );
					var url = $form.attr( "action" );
					var search = $field.val();
					var fieldName = $field.attr( "name" );
					var data = {};
					var $suggestingArea = $( "#js--suggesting" );

					if( suggestingAreaOriginalContent === undefined ){
						suggestingAreaOriginalContent = $suggestingArea.html();
						console.log( suggestingAreaOriginalContent );
					}
					
					search = search.trim();

					if( search === $suggestingArea.data( "suggesting-for" ) ) {
						return;
					}

					$suggestingArea.data( "suggesting-for", search );

					var searchFn = function( search ) {
						if( search === "" ) {
							$suggestingArea.html( suggestingAreaOriginalContent );
							return;
						}

						if ( suggestingCache[ search ] ) {
							$suggestingArea.html( suggestingCache[ search ] );
							// console.log( "replaced from cache" );
							return;
						}

						if( $suggestingArea.data( "suggesting" ) === "yes" ) {
							return;
						}

						$suggestingArea.data( "suggesting", "yes" );

						data[ "format" ] = "snippet";
						data[ fieldName ] = search;
						$.ajax( {
							dataType: "html",
							url: url,
							data: data,
							success: function( snippet ) {
								if( search === $suggestingArea.data( "suggesting-for" ) ) {
									suggestingCache[ search ] = snippet;
								}
								$suggestingArea.data( "suggesting", "" );
								if( search !== $suggestingArea.data( "suggesting-for" ) ) {
									searchFn( $suggestingArea.data( "suggesting-for" ) );
								} else {
									$suggestingArea.html( snippet );
									// console.log( "content replaced" );
								}
							}
						} );
					}

					searchFn( search );

					$( window ).on( "resize", function() {
						suggestingAreaNeedsToBePositioned = true;
						if( suggestingAreaVisible ) {

							// We need to delay a bit to wait for  possible transformations on the page
							setTimeOut( positionSuggestingArea( $field, $suggestingArea ), 5000);
						}
					} );
				};

				$( ".js--search" ).on ( "keyup", function( e ) {
					suggest( e, this, "keyup" );
				} );

				$( "body" ).on( "click keyup", function( e ) {
					var $activeElement = $( e.target );
					var id = $activeElement.attr( "id" );
					var searchFieldIsActiveAndEmpty = $activeElement.hasClass( "js--search" ) && $activeElement.val().length === 0;
					var $suggArea = $( "#js--suggesting" );
					if (
						searchFieldIsActiveAndEmpty || (
							!$activeElement.hasClass( "js--search" ) &&
							id !== "js--suggesting" &&
							$activeElement.closest( "#js--suggesting" ).length === 0
						)
					) {
						if( suggestingAreaVisible ) {
							$suggArea.fadeOut();
							suggestingAreaVisible = false;
							// console.log( "fadeOut" );
						}
					} else {
						positionSuggestingArea( $( ".js--search" ), $suggArea );
						if( !suggestingAreaVisible ) {
							$suggArea.fadeIn();
							suggestingAreaVisible = true;
							// console.log( "fadeIn" );
						}
					}
				} );

				var positionSuggestingArea = function( searchField, suggArea ) {

					// In the mobile layout the search input changes its location
					//if( !suggestingAreaNeedsToBePositioned ) {
					//	return;
					//}

					var fieldOffset = searchField.offset();
					suggArea.css( "top", fieldOffset.top + searchField.outerHeight() + 2 +"px");

					// Get x position of search field right edge
					var rightPos = fieldOffset.left + searchField.outerWidth();

					// Align suggestions to rightPos if there is enough room, center otherwise
					if( rightPos > suggArea.width() ) {
						suggArea.css( "left", rightPos - suggArea.width() + "px" );
					} else {
						suggArea.css( "left", ( document.body.clientWidth - suggArea.width() ) / 2 );
					}

					// console.log( "re-positioned" );

					suggestingAreaNeedsToBePositioned = false;
				}
				// End of Search Suggestions

			}

		},

		categories: {

			// Action-specific code
			detail: function() {
				window.ATK14COMMON.filter_init( "#filter_form" );
			}
		},

		main: {

			// Controller-wide code.
			init: function() {
			},

			// Action-specific code
			index: function() {
			}
		},

		logins: {
			create_new: function() {
				$( "#id_login" ).focus();
			}
		},

		users: {

			// Controller-wide code.
			init: function() {
			},

			// Action-specific code
			create_new: function() {
				/*
				 * Check whether login is available.
				 * Simple demo of working with an API.
				 */
				var $login = $( "#id_login" ),
					m = "Username is already taken.",
					h = "<p class='alert alert-danger'>" + m + "</p>",
					$status = $( h ).hide().appendTo( $login.closest( ".form-group" ) );

				$login.on( "change", function() {

					// Login input value to check.
					var value = $login.val(),
						lang = $( "html" ).attr( "lang" ),

					// API URL.
						url = "/api/" + lang + "/login_availabilities/detail/",

					// GET values for API. Available formats: xml, json, yaml, jsonp.
						data = {
							login: value,
							format: "json"
						};

					// AJAX request to the API.
					if ( value !== "" ) {
						$.ajax( {
							dataType: "json",
							url: url,
							data: data,
							success: function( json ) {
								if ( json.status !== "available" ) {
									$status.fadeIn();
								} else {
									$status.fadeOut();
								}
							}
						} );
					}
				} ).change();
			}
		},

		cards: {

			// Controller-wide code.
			init: function() {
			},

			// Action-specific code
			detail: function() {

				// Tlacitka +/- mnozstvi pri pridani do kosiku
				var qtyButtons = $( ".js-stepper button[data-spinner-button]" );
				qtyButtons.on( "click", function( e ) {
					e.preventDefault();
					var qtyWidget = $( this ).closest( ".js-stepper" );
					var qtyInput = qtyWidget.find( ".js-order-quantity-input" );
					var oldValue = parseInt( qtyInput.val() );
					var qtyMin = parseInt( qtyInput.attr( "min" ) );
					var qtyMax = parseInt( qtyInput.attr( "max" ) );
					var qtyStep = parseInt( qtyInput.attr( "step" ) );
					var newValue;
					if( $( this ).attr( "data-spinner-button" ) === "up" ){
						newValue = Math.min( qtyMax, oldValue + qtyStep );
					} else {
						newValue = Math.max( qtyMin, oldValue - qtyStep );
					}
					qtyInput.val( newValue );
					qtyInput.trigger( "change" );
				} );

				// Update celkove ceny pri zmene mnozstvi
				var qtyInput = $( ".js-quantity-widget .js-quantity-input" );
				qtyInput.on( "change", function() {
					var qtyWidget = $( this ).closest( ".js-quantity-widget" );
					var qty = parseInt( $( this ).val() );
					var unitPrice = parseFloat( qtyWidget.data( "unitprice" ) );
					var totalPrice = qty * unitPrice;
					var totalPriceNice = totalPrice.toFixed(2).replace( ".", "," );
					qtyWidget.find( ".js-quantity-total-price" ).html( totalPriceNice + "&nbsp;Kč" );
					qtyWidget.find( ".js-quantity-suffix" ).css( "display", "inline" );
				} );

				// Kliknuti na preview obrazek v galerii vyvola ve skutecnosti kliknuti na prislusny thumbnail obrazek
				$( ".product-gallery .js_gallery_trigger" ).on( "click", function( e ) {
					e.preventDefault();

					var previewLink = $( this ).find( "a" ).get( 0 );
					
					var imageId = $( previewLink ).data( "preview_for" );
					$( ".product-gallery .gallery__item[data-id=" + imageId + "] a" ).trigger( "click" );
				} );

				// Prepnuti varianty produktu
				$( "#variants-nav a[data-product_id]" ).on( "click", function() {
					var $link = $( this ),
						productId = $link.data( "product_id" ),
						$galleryItem = $( ".product-gallery--with-variants .gallery__item[data-product_id=" + productId + "]" ).eq( 0 ),
						$preview = $( ".product-gallery .js_gallery_trigger a" ),
						$previewImage = $preview.find( "img" );
					if ( !$galleryItem ) { return; }
					$preview.data( "preview_for" , $galleryItem.data( "id" ) );
					$previewImage.attr( "src", $galleryItem.data( "preview_image_url" ) );
					$previewImage.attr( "width", $galleryItem.data( "preview_image_width" ) );
					$previewImage.attr( "height", $galleryItem.data( "preview_image_height" ) );
				} );

			}
		},

		baskets: {

			// Controller-wide code.
			init: function() {
			},

			// Action-specific code
			edit: function() {
				var $basketForm = $( "#form_baskets_edit" );
				var autoRefreshinterval = 1000; // 1 sec

				// Tlacitka +/- editace mnozstvi
				$basketForm.on( "click", ".js-stepper button[data-spinner-button]", function( e ) {
					e.preventDefault();
					var qtyWidget = $( this ).closest( ".js-stepper" );
					var qtyInput = qtyWidget.find( ".js-order-quantity-input" );
					var oldValue = parseInt( qtyInput.val() );
					var qtyMin = parseInt( qtyInput.attr( "min" ) );
					var qtyMax = parseInt( qtyInput.attr( "max" ) );
					var qtyStep = parseInt( qtyInput.attr( "step" ) );
					var newValue;
					if( $( this ).attr( "data-spinner-button" ) === "up" ){
						newValue = Math.min( qtyMax, oldValue + qtyStep );
					} else {
						newValue = Math.max( qtyMin, oldValue - qtyStep );
					}
					qtyInput.val( newValue );
					qtyInput.trigger( "change" );
				} );

				// Odstranit polozku
				/*$( ".js--basket-destroy" ).click( function( e ) {
					var $e = $( e.currentTarget );
					$.ajax( {
						"url": $e.data( "url" ),
						"type": "POST",
						"dataType": "json",
						"success": function( data ) {
										if ( data.emptyBasket ) {
											return location.reload();
										}
										var $table = $e.closest( "table" );
										// UTILS.update_basket( data, $table );
										var $tr = $e.closest( "tr" );
										$tr.fadeOut( $tr.remove );
										}
					} );
					return false;
				} );*/

				// Automaticke prepocitavani kosiku
				setTimeout( function() {
					UTILS.edit_basket_form.auto_refresh( autoRefreshinterval );
				}, autoRefreshinterval );

				// Zachyceni stisku klavesy enter v inputu na polozce kosiku a prekresleni kosiku.
				// Atribut data-ininitial maji pouze inputy na polozkach v kosiku.
				$basketForm.on( "keydown", "input[type=number][data-initial]", function( event ) {
					if ( event.which === 13 ) {
						// console.log( "about to refresh from keydown" );
						UTILS.edit_basket_form.refresh();
						return false;
					}
				} );
			}
		},

		checkouts: {

			// Controller-wide code.
			init: function() {
			},

			set_payment_and_delivery_method: function() {
				UTILS.shipping_rules.checkDependent( {
					determinantName: "delivery_method_id",
					determinedName: "payment_method_id",
					rules: $( "#form_checkouts_set_payment_and_delivery_method" ).data( "rules" )
				} );

				$( "#form_checkouts_set_payment_and_delivery_method :checked" )
					.parents( "li" ).each( function() {
					$( this ).last().addClass( "checked" );
				} );

				$( "#form_checkouts_set_payment_and_delivery_method :radio" ).change( function() {
					if ( $( this ).is( ":checked" ) ) {
						$( this ).closest( ".list--radios" )
							.find( ".checked input[name='group_checkbox']" )
							.attr( "checked", false );
						$( this ).closest( ".list--radios" )
							.find( ".checked" )
							.removeClass( "checked" );
						$( this ).parents( "li" ).last().addClass( "checked" );
					}
				} );
			},

			// Action-specific code
			set_billing_and_delivery_data: function() {

				// Checkbox na zadavani fakturacni adresy
				if( $( "#id_fill_in_invoice_address" ).is( ":checked" ) === false ){
					$( "#invoice-address-fields" ).css( "display", "none" );
				}

				$( "#id_fill_in_invoice_address" ).on( "change", function() {
					if( $( "#id_fill_in_invoice_address" ).is( ":checked" ) === true ) {
						$( "#invoice-address-fields" ).show( 150 );
					} else {
						$( "#invoice-address-fields" ).hide( 150 );
					}
				} );



				// Vyber dorucovacich adres
				$( ".js--predefined-address" ).click( function() {
					var data = $( this ).data( "json" ),
						$card = $( this ).closest( ".js--card-address" ),
						$cards = $( ".js--card-address" );

					$cards.removeClass( "card--active" );
					$card.addClass( "card--active" );

					$( "#form_checkouts_set_billing_and_delivery_data input" ).each( function() {
							var name = this.name;
							if ( name.substr( 0, 9 ) !== "delivery_" ) {
								return;
							}
							name = name.substr( 9 );
							if ( data[ name ] !== undefined ) {
								this.value = data[ name ];
							}
					} );
				} );

			}

		},

		stores: {

			// Controller-wide code.
			init: function() {
			},

			// Action-specific code
			index: function() {
				UTILS.initMultiMap( "allstores_map" );

				var storeList = new UTILS.filterableList( {
					searchInput: 	$( "#stores-filter__input" ),
					clearButton: 	$( "#stores-filter__clear" ),
					submitButton: $( "#stores-filter__submit" ),
					listItems:		$( ".js-stores-cards > .js-store-item" ),
					searchTextSelector: ".js-search-data",
				} );

			},

			// Action-specific code
			detail: function() {

				// Mapa
				UTILS.initSimpleMap( "store-map" );
			}

		},

		styleguides: {

			// Controller-wide code.
			init: function() {
				$( ".styleguide-color-swatches .color-swatch" ).each( function( i, el ) {
					var swatch = $( el );
					var color = swatch.find( ".color-swatch__patch" ).css( "background-color" );
					swatch.find( ".color-swatch__value" ).text( "#" + UTILS.rgb2hex( color ).toUpperCase() );
				} );
				
				// Tlacitka +/- mnozstvi pri pridani do kosiku
				var qtyButtons = $( ".js-stepper button[data-spinner-button]" );
				qtyButtons.on( "click", function( e ) {
					e.preventDefault();
					var qtyWidget = $( this ).closest( ".js-stepper" );
					var qtyInput = qtyWidget.find( ".js-order-quantity-input" );
					var oldValue = parseInt( qtyInput.val() );
					var qtyMin = parseInt( qtyInput.attr( "min" ) );
					var qtyMax = parseInt( qtyInput.attr( "max" ) );
					var qtyStep = parseInt( qtyInput.attr( "step" ) );
					var newValue;
					if( $( this ).attr( "data-spinner-button" ) === "up" ){
						newValue = Math.min( qtyMax, oldValue + qtyStep );
					} else {
						newValue = Math.max( qtyMin, oldValue - qtyStep );
					}
					qtyInput.val( newValue );
					qtyInput.trigger( "change" );
				} );
				
				// Maps
				if( $( "#allstores_map").length > 0 ) {
					UTILS.initMultiMap( "allstores_map" );
				}
				if( $( "#store-map").length > 0 ) {
					UTILS.initSimpleMap( "store-map" );
				}

				// List tree collapse all/expand all toggle
				$( ".js-toggle-all-trees" ).on( "click", function() {
					if( $( this ).hasClass( "collapsed" ) ){
						$( ".list--tree.collapse" ).collapse( "show" );
					} else {
						$( ".list--tree.collapse" ).collapse( "hide" );
					}
					$( this ).toggleClass( [ "collapsed", "expanded" ] )
				} );

			}

		},

		// In this json, the actions for namespace "api" can be defined
		api: {

		}

	};

	/*
	 * Garber-Irish DOM-based routing.
	 * See: http://goo.gl/z9dmd
	 */
	APPLICATION.INITIALIZER = {
		exec: function( namespace, controller, action ) {
			var ns = APPLICATION,
				c = controller,
				a = action;

			if( namespace && namespace.length > 0 && ns[ namespace ] ) {
				ns = ns[ namespace ];
			}

			if ( a === undefined ) {
				a = "init";
			}

			if ( c !== "" && ns[ c ] && typeof ns[ c ][ a ] === "function" ) {
				ns[ c ][ a ]();
			}
		},

		init: function() {
			var body = document.body,
			namespace = body.getAttribute( "data-namespace" ),
			controller = body.getAttribute( "data-controller" ),
			action = body.getAttribute( "data-action" );

			APPLICATION.INITIALIZER.exec( namespace, "common" );
			APPLICATION.INITIALIZER.exec( namespace, controller );
			APPLICATION.INITIALIZER.exec( namespace, controller, action );
		}
	};

	// Expose APPLICATION to the global object.
	window.APPLICATION = APPLICATION;

	// Initialize application.
	APPLICATION.INITIALIZER.init();
} )( window, window.jQuery );
