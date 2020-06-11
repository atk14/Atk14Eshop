Slider
======

[Swiper](https://swiperjs.com/) slider used for all sliders on the site. Note <code>id</code> and <code>data-slider_id</code> attributes - they contain code which must be unique for each instance of slider. This enables to have multiple instances of slider on page.
		

[example]
	
<section class="section--slider">

	<div class="swiper-container" data-slides_per_view="1" data-loop="1" data-autoplay="6000" data-slider_id="5ecbbd720a916" id="swiper_5ecbbd720a916">
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

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_5ecbbd720a916"><span class="sr-only">Předchozí</span></div>
		<div class="swiper-button-next" id="swiper_button_next_5ecbbd720a916"><span class="sr-only">Následující</span></div>
		<div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_5ecbbd720a916"></div>
	</div>
	
</section>

[/example]