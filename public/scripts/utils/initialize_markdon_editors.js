window.UTILS = window.UTILS || { };

window.UTILS.initializeMarkdonEditors = function() {
	// Markdown Editor requires Ace
	ace.config.set( "basePath", "/public/dist/scripts/ace/" );
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
};
