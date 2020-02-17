window.UTILS = window.UTILS || { };
window.UTILS = window.UTILS || { };

window.UTILS.edit_basket_form = { };

window.UTILS.edit_basket_form.auto_refresh = function( interval ) {
	var somethingChanged = false;
	var somethingFocussed = false;
	var focused = document.activeElement;

	$(
		"#form_baskets_edit input[type=number][data-initial]"
	).each( function( index, input ) {
		var $input = $( input );
		if ( "" + $input.val() !== "" + $input.data( "initial" ) ) {
			somethingChanged = true;
		}
		if ( input === focused ) {
			somethingFocussed = true;
		}
	} );

	if ( somethingChanged && !somethingFocussed ) {
		// console.log( "about to refresh from auto_refresh" );
		window.UTILS.edit_basket_form.refresh();
		setTimeout( function() {
			window.UTILS.edit_basket_form.auto_refresh( interval );
		}, interval );
		return;
	}

	setTimeout( function() {
		window.UTILS.edit_basket_form.auto_refresh( interval );
	}, interval );
};

window.UTILS.edit_basket_form.refresh = function() {
	var $form = $( "#form_baskets_edit" );
	if ( $form.attr( "data-submitting" ) ) {
		return;
	}
	$form.attr( "data-submitting", "true" );
	// console.log( "refreshing..." );
	ATK14.handleRemote( $form );
	$form.removeAttr( "data-submitting" );
};
