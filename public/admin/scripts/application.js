/* global window */
( function( window, $, undefined ) {
	var document = window.document,
		ace = window.ace,
		UTILS = window.UTILS,

	ADMIN = {

		common: {

			// Application-wide code.
			init: function() {
				ADMIN.utils.handleSortables();
				window.UTILS.Suggestions.handleSuggestions();
				window.UTILS.Suggestions.handleTagsSuggestions();
				ADMIN.utils.initializeMarkdonEditors();
				UTILS.AsyncImageUploader.init();
				ADMIN.utils.handleCopyIobjectCode();
				window.UTILS.Suggestions.handleCategoriesSuggestions();

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

				UTILS.leaving_unsaved_page_checker.init();

				// eslint-disable-next-line no-unused-vars
				var filterableNav = new UTILS.filterableList( {
					searchInput: 	$( "#nav-filter__input" ),
					clearButton: 	$( "#nav-filter__clear" ),
					submitButton: $( "#nav-filter__submit" ),
					listItems:		$( ".js-filterable-nav > .nav-item" ),
					searchTextSelector: ".js-search-data",
				} );

				// Back to top button display and handling
				$( window ).on( "scroll", function(){
					var backToTopBtn = $ ( "#js-scroll-to-top" );
					if( $( window ).scrollTop() > 100 ) {
						backToTopBtn.addClass( "active" );
					} else {
						backToTopBtn.removeClass( "active" );
					}
				} );
				$( window ).trigger( "scroll" );

				$ ( "#js-scroll-to-top" ).on( "click", function( e ){
					e.preventDefault();
					$( "html, body" ).animate( { scrollTop: 0 }, "fast" );
				} );

				UTILS.async_file_upload.init();

				// Admin menu toggle on small devices
				$( ".nav-section__toggle" ).on( "click", function( e ) {
					e.preventDefault();
					$( this ).closest( ".nav-section" ).toggleClass( "expanded" );
				} );

				// Dark mode toggle 
				$( "#js--darkmode-switch" ).on( "click", function(){
					var mode;
					if( $(this).prop( "checked" ) ) {
						$( "body" ).addClass( "dark-mode" );
						mode = "dark";
						document.cookie = "dark_mode=1;path=/";
					} else {
						$( "body" ).removeClass( "dark-mode" );
						mode = "light";
						document.cookie = "dark_mode=;path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT";
					}

					// darkModeChange event is triggered on dark mode de/activation
					var evt = new CustomEvent( "darkModeChange", { detail: mode } );
					document.dispatchEvent(evt);
				} );
			}

		},
		
		main: {
			init: function() {
				UTILS.initDashboardOrdersChart();
			}
		},

		cards: {
			edit: function() {
				ADMIN.utils.handleCardToCategories();
			}
		},

		orders: {
			index: function() {

				// Reset filtering form and reload
				$( ".form-filter button[type=\"reset\"]" ).on( "click", function( e ){
					e.preventDefault();
					var frm = $( this ).closest( ".form-filter" );
					frm.get(0).reset();
					frm.find( "input[type=\"text\"], input[type=\"search\"]" ).each( function( i, el ) {
						$( el ).val( "" );
					} );
					frm.find( "select" ).each( function( i, el ) {
						$( el ).find( "option:eq(0)" ).prop( "selected", true );
					} );
					frm.submit();
				} );

				// Decorate filtering form fields with not default
				$( ".form-filter" ).find( "input[type=\"text\"], input[type=\"search\"], select" ).each( function( i, el ) {
					var element = $(el);
					switch( ( element.prop( "tagName" ).toLowerCase() ) ){
						case "input":
							if( element.val() ){
								element.addClass( "active-filter" );
							}
							break;
						case "select":
							if( element.prop( "selectedIndex" ) !== 0 ) {
								element.addClass( "active-filter" );
							}
							break;
					} 
				} );
			}
		},

		category_trees: {
			detail: function() {
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

		utils: {

			initializeMarkdonEditors: function() {

				// Markdown Editor requires Ace
				ace.config.set( "basePath", "/public/admin/dist/scripts/ace/" );
				$.each( $( "textarea[data-provide=markdown]" ), function( i, el ) {
					$( el ).markdownEditor( {
						preview: true,
						onPreview: function( content, callback ) {
							var lang = $( "html" ).attr( "lang" );
							$.ajax( {
								type: "POST",
								url: "/api/" + lang + "/markdown/transform/",
								data: {
									source: content,
									base_href: $( el ).data( "base_href" )
								},
								success: function( output ) {
									callback( output );
								}
							} );
						}
					} );
				} );
			},

			handleFormErrors: function( errors ) {
				$.each( errors, function( field, errorList ) {
					var $field = $( "#id_" + field ),
						$fg = $field.closest( ".form-group" ),
						errorMsgs = [];

					// Add proper class for error styling.
					$fg.addClass( "has-error" );

					// Prepeare error messages list.
					errorMsgs.push( "<ul class='help-block help-block-errors'>" );
					$.each( errorList, function( i, errorMsg ) {
						errorMsgs.push( "<li>" + errorMsg + "</li>" );
					} );
					errorMsgs.push( "</ul>" );

					// Insert error messages list into form.
					$( errorMsgs.join( "" ) ).insertAfter( $field );
				} );
			},

			clearErrorMessages: function( $form ) {
				$form.find( ".has-error" ).removeClass( "has-error" );
				$form.find( ".help-block-errors" ).remove();
			},

			handleCardToCategories: function() {
				var $form = $( "#form_cards_add_to_category" ),
					$input = $( "#id_category" ),
					$categies = $( "#categies" );

				$form.on( "ajax:success", function( jqEv, json ) {
					ADMIN.utils.clearErrorMessages( $form );
					$categies.html( json.snippet );
					ADMIN.utils.handleSortables( $categies.find( ".list-sortable" ) );

					if ( !json.hasErrors ) {
						$input.val( "" );
					} else {
						ADMIN.utils.handleFormErrors( json.errors );
					}

					$input.focus().select();
				} );
			},

			// ADMIN.utils.handleFormErrors();
			// ADMIN.utils.handleFormErrors( ".list-sortable" );
			// ADMIN.utils.handleFormErrors( $element.find( "ul" ) );

			handleSortables: function() {
				// Sortable lists.

				var $sortable = $( ".list-sortable" ),
					glyph = "<span class='fas fa-grip-vertical text-secondary handle pr-3' " +
						" title='sorting'></span>";
					
				if ( $sortable.length ) {
					$sortable.find( ".list-group-item" ).prepend( glyph );

					$sortable.each( function( i, el ) {
						// eslint-disable-next-line no-undef
						new Sortable( el, {
							handle: ".handle",
							onUpdate: function( e ) {
								var $list = $( e.target );
								var $item = $( e.item );
								var url = $list.data( "sortable-url" );
								var id = $list.data( "sortable-param" ) || "id";
								var data = {
									rank: $item.index()
								};
								data[ id ] = $item.data( "id" );
								
								$.ajax( {
									type: "POST",
									url: url,
									data: data,
									success: function() {
									},
									error: function() {
									}
								} );
							}
						} );
					} );
				}
			},

			// Copy iobject to clipboard
			handleCopyIobjectCode: function() {
				$( ".iobject-copy-code" ).popover();
				$( ".iobject-copy-code" ).on( "click", function( e ) {
					e.preventDefault();
					var code = $( this ).closest( ".iobject-code-wrap" ).find( ".iobject-code" ).text();
					var el = document.createElement( "textarea" );
					el.value = code;
					document.body.appendChild( el );
					el.select();
					document.execCommand( "copy" );
					document.body.removeChild( el );
					$( this ).trigger( "focus" );
				} );
			},

			handleCategoriesSuggestions: function() {
				ADMIN.utils.categoriesSuggest( "[data-suggesting_categories='yes']" );
			},
		}
	};

	/*
	 * Garber-Irish DOM-based routing.
	 * See: http://goo.gl/z9dmd
	 */
	ADMIN.INITIALIZER = {
		exec: function( namespace, controller, action ) {
			var ns = ADMIN,
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

			ADMIN.INITIALIZER.exec( namespace, "common" );
			ADMIN.INITIALIZER.exec( namespace, controller );
			ADMIN.INITIALIZER.exec( namespace, controller, action );
		}
	};

	// Expose ADMIN to the global object.
	window.ADMIN = ADMIN;

	// Initialize application.
	ADMIN.INITIALIZER.init();
} )( window, window.jQuery );
