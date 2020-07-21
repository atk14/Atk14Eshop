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
				UTILS.handleSuggestions();
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
					console.log( "qty", qty, "*", unitPrice, "=", totalPriceNice );
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

			}
		}

	};

	/*
	 * Garber-Irish DOM-based routing.
	 * See: http://goo.gl/z9dmd
	 */
	APPLICATION.INITIALIZER = {
		exec: function( controller, action ) {
			var ns = APPLICATION,
				c = controller,
				a = action;

			if ( a === undefined ) {
				a = "init";
			}

			if ( c !== "" && ns[ c ] && typeof ns[ c ][ a ] === "function" ) {
				ns[ c ][ a ]();
			}
		},

		init: function() {
			var body = document.body,
			controller = body.getAttribute( "data-controller" ),
			action = body.getAttribute( "data-action" );

			APPLICATION.INITIALIZER.exec( "common" );
			APPLICATION.INITIALIZER.exec( controller );
			APPLICATION.INITIALIZER.exec( controller, action );
		}
	};

	// Expose APPLICATION to the global object.
	window.APPLICATION = APPLICATION;

	// Initialize application.
	APPLICATION.INITIALIZER.init();
} )( window, window.jQuery );
