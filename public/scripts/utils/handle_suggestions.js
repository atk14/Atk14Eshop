window.UTILS = window.UTILS || { };

window.UTILS.handleSuggestions = function() {

	var $ = window.jQuery;

	$( document ).on( "keyup.autocomplete", "[data-suggesting='yes']", function(){
		$( this ).autocomplete( {
			source: function( request, response ) {
				var $el = this.element,
					url = $el.data( "suggesting_url" ),
					term;
				term = request.term;

				$.getJSON( url, { q: term }, function( data ) {
					response( data );
				} );
			}
		} );
	} );
};
