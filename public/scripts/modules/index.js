
var swiperElement = $( ".swiper" );
if ( swiperElement.length ) {
import( "./swiper.js" ).then(({ default: initSwiper }) => {
	initSwiper( swiperElement );
});
}
