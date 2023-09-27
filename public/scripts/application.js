/* global window */
( function( window, $, undefined ) {
	"use strict";
	var document = window.document,
	UTILS = window.UTILS, // Uncomment this if you need something from UTILS

	APPLICATION = {
		common: {

			// Application-wide code.
			init: function() {

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

				// Init Swiper
				UTILS.initSwiper();

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
				$navbar.find( $dropdown ).on ( "mouseleave", function() {
						var $this = $(this);
						$this.removeClass( showClass );
						$this.find( $dropdownToggle ).attr( "aria-expanded", "false" );
						$this.find( $dropdownMenu ).removeClass( showClass ).hide();
				} );
				UTILS.handleSuggestions();

				// Mobile search show/hide toggle
				$( ".js--search-toggle" ).on( "click", function( e ) {
					e.preventDefault();
					var $form = $( "#js--mobile_search_field" );
					$form.toggleClass( "show" );
					if( $form.is( ":visible" ) ) {
						$form.find( "input[type=text]" ).focus();
					}
				} );
			
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

				// Floating cart info show/hide 
				// Using IntersectionObserver rather than watching scroll
				if ( "IntersectionObserver" in window && document.getElementsByClassName( "js--basket_info_float-container" ).length > 0 && document.getElementsByClassName( "js--mainbar__cartinfo" ).length > 0) {
					function floatBasketInfo( changes ){
						var floatBasket = $( ".js--basket_info_float-container" );
						changes.forEach( function( change ) {
							if ( change.isIntersecting ) {
								floatBasket.removeClass( "show" );
							} else {
								floatBasket.addClass( "show" );
							}
						});
					}

					// Watch if top menu basket info is in viewport
					var viewportObserver = new IntersectionObserver( floatBasketInfo, {
						root: null, // relative to document viewport 
						rootMargin: "0px", // margin around root. Values are similar to css property. Unitless values not allowed
						threshold: 0.75 // visible amount of item shown in relation to root
					} );
					viewportObserver.observe( $( ".js--mainbar__cartinfo" ).get( 0 ) );
				}

				window.UTILS.searchSuggestion( "js--search", "js--suggesting" );

				// Expanding/collapsing FAQ items
				$( "dl.faq dt, ul.faq .faq__q, ol.faq .faq__q" ).on( "click", function( e ) {
					var qtitle =$( e.target );
					var qcontent = qtitle.next()
					qtitle.toggleClass( "expanded" );
					if ( qtitle.hasClass( "expanded" ) ) {
						qcontent.slideDown( "fast" );
					} else {
						qcontent.slideUp( "fast" );
					}
				} );

				// Set proper scale for product card image scaling on hover
				var setCardHoverScale = function() {
					// find card image
					var cardImage = $( ".section--list-products .card .card-img-top" );
					if( cardImage.length > 0 ) {
						// access to values stored in css variables
						var r = document.querySelector( ":root " );
						var rs = getComputedStyle( r );
						// get card image actual width (CAUTION: assumes all cards are the same width)
						var cardW = $( ".section--list-products .card .card-img-top" ).width();
						// read desired hover width from css
						var imgW = rs.getPropertyValue( "--card_hover_width" );
						var hoverScale = imgW / cardW;
						//console.log( {cardW}, {imgW}, {hoverScale} );
						// set desired scale value to css variable
						r.style.setProperty( "--card_hover_scale", hoverScale );
					}
				};
				setCardHoverScale();
				window.addEventListener( "resize", setCardHoverScale );

				// Init NoUiSlider

				// Scroll Sidebar
				// To make it work enable sticky-sidebar.js in vendorScripts list in gulpfile.js
				if( $( "nav.nav-section" ).length && typeof StickySidebar !== "undefined" ) {
					// eslint-disable-next-line no-undef,no-unused-vars
					var sidebar = new StickySidebar( ".nav-section", {
						topSpacing: 10,
						bottomSpacing: 10,
						containerSelector: ".body__sticky-container",
						innerWrapperSelector: "#sidebar_menu",
						minWidth: 767,
					});
					$( ".nav-section" ).find( ".js-sidebar-toggle" ).on( "click", function() {
						$( ".nav-section" ).toggleClass( "show-sm" );
					} );
				}
				// Init offvanvas component
				window.offCanvas = new window.UTILS.BSOffCanvas();

				// Init offcanvas basket preview
				window.basketOffcanvas = new window.UTILS.OffcanvasBasket();

				// Add-to-cart animation on cards button
				$( ".js--card-add-to-cart-btn" ).on( "click", function() {
					$( this ).closest( ".card" ).addClass( "card--in-basket" );
				} );

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

				// Prepnuti varianty produktu
				$( "#variants-nav a[data-product_id]" ).on( "click", function() {
					var $link = $( this ),
						productId = $link.data( "product_id" ),
						$galleryItem = $( ".product-gallery--with-variants .gallery__item[data-product_id=" + productId + "]" ).eq( 0 ),
						$preview = $( ".product-gallery .js_gallery_trigger a" ),
						$previewImage = $preview.find( "img" );
					if ( !$galleryItem ) { return; }
					$preview.data( "preview_for" , $galleryItem.data( "id" ) );
					$preview.attr( "data-preview_for" , $galleryItem.data( "id" ) );
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

				// Auto submission of the set-region form
				$("#form_regions_set_region select").on( "change",  function() {
					$( document.body ).addClass( "loading" );
					$(this).parent( "form" ).submit();
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

				// Auto submission of the set-region form
				$("#form_regions_set_region select").on( "change",  function() {
					$( document.body ).addClass( "loading" );
					$(this).parent( "form" ).submit();
				} );
			},

			// Action-specific code
			set_billing_and_delivery_data: function() {

				// Checkbox na zadavani fakturacni adresy
				if( $( "#id_fill_in_invoice_address" ).length && $( "#id_fill_in_invoice_address" ).is( ":checked" ) === false ){
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
						$card = $( this ).closest( ".card" ).find( ".js--card-address" ),
						$cards = $( ".js--card-address" );
					$cards.removeClass( "card--active" );
					$card.addClass( "card--active" );

					$( "#form_checkouts_set_billing_and_delivery_data input, #form_checkouts_set_billing_and_delivery_data select" ).each( function() {
							var name = this.name;
							var $input = $( this );
							var origColor = $input.css( "color" );
							var backgroundColor = $input.css( "background-color" );

							if ( name.substr( 0, 9 ) === "delivery_" ) {
								name = name.substr( 9 );
							} else if ( name !== "phone" ) {
								return;
							}
							if ( data[ name ] !== undefined ) {
								this.value = data[ name ];
								$input.css( "color", backgroundColor );
								$input.animate( {
									color: origColor
								} );
							}
					} );
				} );
			},

			summary: function() {
				// Before order submit, check if confirmation checkbox is checked
				// If not show reminder
				var btn = $( "form#form_checkouts_summary .btn[type='submit']" );
				var confirmationFormGroup = $( "form#form_checkouts_summary .form-group--id_confirmation" );
				var confirmationChkBox = $( "form#form_checkouts_summary #id_confirmation" );
				var reminderTimeout;
				$( "form#form_checkouts_summary" ).on( "submit", function( e ){
					var errMsg = confirmationChkBox.parents().find( "*[data-confirmation-reminder]" ).data( "confirmation-reminder" );
					btn.popover( {
						customClass: "popover--danger popover--bold",
						placement: "top",
						content: errMsg,
					} );
					if( confirmationChkBox.prop( "checked" ) !== true ) {
						e.preventDefault();
						btn.popover( "show" );
						confirmationFormGroup.addClass( "form-group--has-error" );
						reminderTimeout = setTimeout( hideReminderPopover, 3000 );
					}else{
						//e.preventDefault();
						hideReminderPopover();
						confirmationFormGroup.removeClass( "form-group--has-error" );					
					}
				} );
				confirmationChkBox.on( "change", function(){
					if( confirmationChkBox.prop( "checked" ) ){
						hideReminderPopover();
						confirmationFormGroup.removeClass( "form-group--has-error" );
					}
				} );
				var hideReminderPopover = function() {
					clearTimeout( reminderTimeout );
					btn.popover( "hide" );
				}
			}

		},

		stores: {

			// Controller-wide code.
			init: function() {
			},

			// Action-specific code
			index: function() {
				UTILS.initMultiMap( "allstores_map" );

				// eslint-disable-next-line no-unused-vars
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

				// TOC search
				// eslint-disable-next-line no-unused-vars
				var storeList = new UTILS.filterableList( {
					searchInput: 	$( "#chapter_filter" ),
					clearButton: 	false,
					submitButton: false,
					listItems:		$( ".js--chapter_toc > *" ),
					searchTextSelector: false,
				} );

			}

		},

		orders: {
			index: function() {
				$( ".js--card-thumbnails__more" ).on( "click", function( e ) {
					e.preventDefault();
					console.log($(this));
					$( this ).parent().find( ".d-none" ).removeClass( "d-none" );
					$( this ).remove();
				} );
			}
		},

		// In this json, the actions for namespace "api" can be defined
		api: {
			common: {

				// Application-wide code.
				init: function() {

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
				}
			}

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
