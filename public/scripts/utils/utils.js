// This is a place for some tools required in the application

window.UTILS = window.UTILS || { };

window.UTILS.helloWorld = function() {
	console.log( "Hello World" );
};

window.UTILS.initSwiper = function() {

	var $ = window.jQuery;

	$( ".swiper-container" ).each( function( index, container ) {
		var $container = $( container );
		var slidesPerView = $container.data( "slides_per_view" );
		var loop = $container.data( "loop" );
		var autoplay = $container.data( "autoplay" );
		var sliderId = $container.data( "slider_id" );

		if( typeof( autoplay ) === "number" ){
			autoplay = {
				delay: autoplay,
			};
		}

		// Swiper init parameters
		var initObject = {
			slidesPerView: slidesPerView,
			navigation: {
				nextEl: "#swiper_button_next_" + sliderId,
				prevEl: "#swiper_button_prev_" + sliderId,
			},
			pagination: {
				el: "#swiper_pagination_" + sliderId,
				clickable: true,
			},
			loop: loop,
			autoplay: autoplay,
			speed: 600,
			roundLengths: false,
			watchOverflow: true,
			spaceBetween: 0,
		};

		// More Swiper init params for some specific layouts
		if ( slidesPerView === "auto" ) {
			initObject.spaceBetween = 30;
		} else {
			if( slidesPerView > 1 ){
				initObject.breakpoints = {
					976: {
						slidesPerView: 2,
						slidesPerGroup: 2,
					},
					740: {
						slidesPerView: 1,
						slidesPerGroup: 1,
					}
				};
			}
		}

		// eslint-disable-next-line
		var swiper = new Swiper( container, initObject );
	} );
};

