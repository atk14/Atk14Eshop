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
		var breakpoint = $container.data( "breakpoint" );
		var centeredSlides = $container.data( "centered_slides" );

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
			initObject.spaceBetween = 10;

			// One slide per view on small viewports, auto on screen width > breakpoint
			if ( typeof( breakpoint ) === "number" ) {
				initObject.slidesPerView = 1;
				initObject.breakpoints = {};
				initObject.breakpoints[breakpoint] = {
					slidesPerView: "auto",
				};
			}
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
		if ( centeredSlides ) {
			initObject.centeredSlides = centeredSlides;

			// Workaround for buggy behaviour when centeredSlides=true and slidesPerView=auto
			initObject.on = {
				imagesReady: function() {
					this.slideToLoop( 0, 0 );
					if( autoplay ) {
						this.autoplay.start();
					}
				}
			};
		}

		// eslint-disable-next-line
		var swiper = new Swiper( container, initObject );
	} );
};

window.UTILS.rgba2hex = function( orig ) {
	var a,
	rgb = orig.replace(/\s/g, "").match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
	alpha = (rgb && rgb[4] || "").trim(),
	hex = rgb ?
	( rgb[ 1 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 2 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 3 ] | 1 << 8 ).toString( 16 ).slice( 1 ) : orig;

	if ( alpha !== "" ) {
		a = alpha;
	} else {
		a = 01;
	}
	// multiply before convert to HEX
	a = ( ( a * 255 ) | 1 << 8 ).toString( 16 ).slice( 1 );
	hex = hex + a;

	return hex;
};

window.UTILS.rgb2hex = function( orig ) {
	var
	rgb = orig.replace(/\s/g, "").match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
	hex = rgb ?
	( rgb[ 1 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 2 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 3 ] | 1 << 8 ).toString( 16 ).slice( 1 ) : orig;

	return hex;
};
