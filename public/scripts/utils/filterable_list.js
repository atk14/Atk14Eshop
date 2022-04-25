window.UTILS = window.UTILS || { };

/*
Filterable list
Options:
	searchInput: 	$( "#stores-filter__input" )  						:  input text field: jQuery object
	clearButton: 	$( "#stores-filter__clear" )							: clear button: jQuery object
	submitButton: $( "#stores-filter__submit" )							: submit button: jQuery object
	listItems:		$( ".js-stores-cards > .js-store-item" ) 	 : searched items: jQuery object
	searchTextSelector: ".js-search-data" 									: optional - selector of element with searchable text: string
	
	If searchTextSelector is not set entire text content of listItems is searched.

*/
window.UTILS.filterableList = function( options ) {
	this.options = options;
	var myInstance = this;

	// Handle search input typing, blur, ESC key
	this.options.searchInput.on( "keyup blur", function( e ) {
		if( e.type === "keyup" ) {
			var code = e.charCode || e.keyCode;
			if( code === 27 ){
				myInstance.options.searchInput.val( "" );
			}
		}
		myInstance.handlefilterableList( e );
	} );
	

	// Clear button handler
	if( this.options.clearButton ){
		this.options.clearButton.on( "click", function( e ) {
			myInstance.options.searchInput.val( "" );
			myInstance.handlefilterableList( e );
		} );
	}

	// Submit button handler
	if( this.options.submitButton ){
		this.options.submitButton.on( "click", function( e ) {
			myInstance.handlefilterableList( e );
		} );
	}
	
	// Filter items in list
	this.handlefilterableList = function( e ) {
		var $ = window.jQuery;
		e.preventDefault();
		var searchString = myInstance.options.searchInput.val().toLowerCase();

		if ( searchString.length ) {
			if( this.options.clearButton ){
				myInstance.options.clearButton.removeClass( "d-none" );
			}
			myInstance.options.listItems.each( function( i, el ) {
				var item = $( el );
				if( myInstance.options.searchTextSelector ){
					var itemText = item.find( myInstance.options.searchTextSelector ).text();
				} else {
					var itemText = item.text();
				}
				if ( itemText.toLowerCase().indexOf( searchString ) > -1 ) {
					item.removeClass( "d-none" );
				} else {
					item.addClass( "d-none" );
				}
			} );
		} else {
			if( this.options.clearButton ){
				myInstance.options.clearButton.addClass( "d-none" );
			}
			myInstance.options.listItems.removeClass( "d-none" );
		}
	};

};
