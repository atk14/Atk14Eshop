window.UTILS = window.UTILS || { };
//
// Zajisti vyber dorucovaci posty ve vyberu dopravy a platby

var $ = window.jQuery;
var selectorBranchNeededField = "input[data-branch_needed='1'][name='delivery_method_id']";

window.UTILS.deliveryServiceBranchSelector = function() {
	console.log( "hello" );
	$( "#form_delivery_service_branches_set_branch" )
		.on( "autocompleteselect", function( event, ui ) {
			console.log( "autocompleteselect" );
			event.preventDefault();
			$( event.target ).val( ui.item.value );
			$( event.target ).parents( "form" ).submit();
		} )
		.on( "autocompletefocus", function( event, ui ) {
			console.log( "autocompletefocus" );
			event.preventDefault();
			$( event.target ).val( ui.item.label );
		} );

	// Otevreni dialogu po zvoleni dorucovaci sluzby s vyberem pobocky
	$( selectorBranchNeededField  )
		.unbind( "change.delivery" )
		.bind( "change.delivery", function() {
			console.log( "change.delivery bound" );
			if ( $( this ).is( ":checked" ) ) {

				$( this ).parents( "li" )
					.find( ".delivery_service_branch .branch_button > a" )
					.trigger( "click" );
			}
		} );

};

