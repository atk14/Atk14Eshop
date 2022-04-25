Slider
======

[Swiper](https://swiperjs.com/) slider used for all sliders on the site. Note <code>id</code> and <code>data-slider_id</code> attributes - they contain code which must be unique for each instance of slider. This enables to have multiple instances of slider on page.

## Basic slider with image and text content

Slides with images and text. Fourth slide in example is image only with no text.

[example]
	
<section class="section--slider">

	<div class="swiper" data-slides_per_view="1" data-loop="1" data-autoplay="6000" data-slider_id="5ecbbd720a916" id="swiper_5ecbbd720a916">
		<div class="swiper-wrapper">

			<div class="swiper-slide slider-item-0">
				<div class="swiper-slide__image">
					<img src="http://i.pupiq.net/i/6f/6f/ac0/2dac0/2000x1335/cE8OAG_900x600xc_db480678eed2b0d9.jpg" class="img-fluid" alt="Lorem ipsum">
				</div>
				<div class="swiper-slide__text">
					<div>
						<h3 class="slide-title">Lorem ipsum</h3>
						<p>Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.</p>
					</div>
					<div>
						<a href="#" class="btn btn-sm btn-outline-primary">Více informací <i class="fas fa-chevron-right"></i></a>
					</div>
				</div>
			</div>
			
			<div class="swiper-slide slider-item-1">
				<div class="swiper-slide__image">
					<img src="http://i.pupiq.net/i/6f/6f/ab9/2dab9/2000x1419/iJDTeF_900x600xc_ef81597cc19682c7.jpg" class="img-fluid" alt="Lorem ipsum">
				</div>
				<div class="swiper-slide__text">
					<div>
						<h3 class="slide-title">Lorem ipsum</h3>
						<p>Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.</p>
					</div>
					<div>
						<a href="#" class="btn btn-sm btn-outline-primary">Více informací <i class="fas fa-chevron-right"></i></a>
					</div>
				</div>
			</div>
			
			<div class="swiper-slide slider-item-2">
				<div class="swiper-slide__image">
					<img src="http://i.pupiq.net/i/6f/6f/ac1/2dac1/2000x1334/WygG5u_900x600xc_b28ee7797fd29766.jpg" class="img-fluid" alt="Lorem ipsum">
				</div>
				<div class="swiper-slide__text">
					<div>
						<h3 class="slide-title">Lorem ipsum</h3>
						<p>Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.</p>
					</div>
					<div>
					</div>
				</div>
			</div>
			<div class="swiper-slide slider-item--3">
				<a href="#">
					<img src="http://i.pupiq.net/i/6f/6f/22a/3022a/2000x1500/8o0zwL_1500x500xc_17c2847a5797fc3e.jpg" class="d-none d-md-block img-fluid" alt="">
					<img src="http://i.pupiq.net/i/6f/6f/22a/3022a/2000x1500/8o0zwL_900x300xc_2fe310d7f86c1bdd.jpg" class="d-block d-md-none img-fluid" alt="">
				</a>
			</div>
		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_5ecbbd720a916"><span class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next" id="swiper_button_next_5ecbbd720a916"><span class="sr-only">Následující</span></div>
		<div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_5ecbbd720a916"></div>
	</div>
	
</section>
[/example]

If there is just one slide only, it is possible to use it without <code>.swiper</code> and <code>.swiper-wrapper</code> wraping elements and without navigation elements. Our <code>_slider.tpl</code> template does this automatically.

[example]
	
<section class="section--slider">

	<div class="swiper-slide slider-item-0">
		<div class="swiper-slide__image">
			<img src="http://i.pupiq.net/i/6f/6f/ac0/2dac0/2000x1335/cE8OAG_900x600xc_db480678eed2b0d9.jpg" class="img-fluid" alt="Lorem ipsum">
		</div>
		<div class="swiper-slide__text">
			<div>
				<h3 class="slide-title">Lorem ipsum</h3>
				<p>Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.</p>
			</div>
			<div>
				<a href="#" class="btn btn-sm btn-outline-primary">Více informací <i class="fas fa-chevron-right"></i></a>
			</div>
		</div>
	</div>

</section>
[/example]

## Image slider

Layout is controlled by data-attributes. Only small subset of Swiper parameters is supported in data attributes. Images may be or not wrapped in links.

### Slides per view: auto, centered slides: true

[example]
<section class="section--slider">

	<div class="swiper swiper--images" data-slides_per_view="auto" data-loop="1" data-autoplay="6000" data-slider_id="5ef491cf8f7dd" id="swiper_5ef491cf8f7dd" data-breakpoint="600" data-centered_slides="1">
		<div class="swiper-wrapper">

			<div class="swiper-slide slider-item-0" style="width: auto">
				<a href="#" title="Lorem ipsum">
					<img src="http://placekitten.com/500/300" class="img-fluid" alt="Lorem ipsum">
				</a>
			</div>
			<div class="swiper-slide slider-item-1" style="width: auto">
				<a href="#" title="Lorem ipsum">
					<img src="http://placekitten.com/500/300" class="img-fluid" alt="Lorem ipsum">
				</a>
			</div>
			<div class="swiper-slide slider-item-2" style="width: auto">
				<img src="http://placekitten.com/500/300" class="img-fluid" alt="Lorem ipsum">
			</div>
			<div class="swiper-slide slider-item-3" style="width: auto">
				<img src="http://placekitten.com/500/300" class="img-fluid" alt="">
			</div>

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_5ef491cf8f7dd"><span class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next" id="swiper_button_next_5ef491cf8f7dd"><span class="sr-only">Následující</span></div>
		<div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_5ef491cf8f7dd"></div>
	</div>
</section>
[/example]

### Slides per view: 1

[example]
<section class="section--slider">

	<div class="swiper swiper--images" data-slides_per_view="1" data-loop="1" data-autoplay="6000" data-slider_id="bvbvccv" id="swiper_bvbvccv" data-breakpoint="600">
		<div class="swiper-wrapper">

			<div class="swiper-slide slider-item-0" style="width: auto">
				<a href="#" title="Lorem ipsum">
					<img src="http://placekitten.com/1000/600" class="img-fluid" alt="Lorem ipsum">
				</a>
			</div>
			<div class="swiper-slide slider-item-1" style="width: auto">
				<a href="#" title="Lorem ipsum">
					<img src="http://placekitten.com/1000/600" class="img-fluid" alt="Lorem ipsum">
				</a>
			</div>
			<div class="swiper-slide slider-item-2" style="width: auto">
				<img src="http://placekitten.com/1000/600" class="img-fluid" alt="Lorem ipsum">
			</div>
			<div class="swiper-slide slider-item-3" style="width: auto">
				<img src="http://placekitten.com/1000/600" class="img-fluid" alt="">
			</div>

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_bvbvccv"><span class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next" id="swiper_button_next_bvbvccv"><span class="sr-only">Následující</span></div>
		<div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_bvbvccv"></div>
	</div>
</section>
[/example]