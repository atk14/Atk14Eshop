
var swiperElement = $( ".swiper" );
if ( swiperElement.length ) {
import( "./swiper.js" ).then(({ default: initSwiper }) => {
	initSwiper( swiperElement );
});
}

var basketElement = $( "#form_checkouts_set_payment_and_delivery_method" );
if ( basketElement.length ) {
	import( "./basket_shipping_rules.js" ).then( ( { default: checkCombinations } ) => {
		checkCombinations( {
			determinantName: "delivery_method_id",
			determinedName: "payment_method_id",
			rules: $( "#form_checkouts_set_payment_and_delivery_method" ).data( "rules" )
		} )
	} );
}

var pagers = $( ".ajax_pager" );
if ( pagers.length ) {
	import( "./pager.js" ).then( ( { default: pager } ) => {
		pager.init();
	} );
}
