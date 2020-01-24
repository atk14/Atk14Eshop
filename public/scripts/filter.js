if ( !window.ATK14COMMON ) {
		window.ATK14COMMON = {};
}

window.ATK14COMMON.filter_init = function( selector, onlyFields ) {
			var $=window.$;
			var $form = $( selector );
			if ( !$form.length ) {
				return;
			}
			var form = $form[ 0 ];
			form.filtering = 0;

			//Hack pro CSS styly
		  $( selector + " input:checked" ).closest( "li" ).addClass( "checkbox--checked" );

			$( selector + " :checkbox," +
				 selector + " select," +
				 selector + " input[type=radio]," +
				 selector + " input[type=number]" ).
												on( "change", function( ) {
				if ( form.timeoutId ) {
					clearTimeout( form.timeoutId );
				}
				form.timeout = function() {
					clearTimeout( form.timeoutId );
					form.timeoutId = null;
					$form.trigger( "submit" );
				};
				form.timeoutId = setTimeout( form.timeout, 500 );
			} );

			$form.on( "mouseleave", function() {
				if ( form.timeoutId ) {
					form.timeout();
				}
			} );

			if ( !onlyFields ) {
				$form.on( "ajax:beforeSend", function() { form.filtering++; } );

				$form.on( "click", ".js-filter-checkbox-label", function( e ) {
					$( e.target ).closest( "div" ).children( "input" ).click();
					e.preventDefault();
				} );

				$form.on( "click", ".nav-link", function( e ) {
					$form.find( "input[name=active_filter_page]" ).val(
						$( e.target ).data( "page" )
					);
				} );
		}
};
