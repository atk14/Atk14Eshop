{render partial="shared/layout/content_header" title=$page_title} 

<p>You should see two slides displayed at once on large viewport, one slide at medium and small viewports</p>

<style>
  .swiper-slide {
    padding: 60px;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    min-height: 200px !important;
  }
</style>
<section class="section--slider">

  <div class="swiper" data-slides_per_view="1" data-loop="1" data-autoplay="6000" data-slider_id="test_slider_1" id="swiper_test_slider_1" data-custom_config="sliderCards">
    <div class="swiper-wrapper">

      <div class="swiper-slide" style="background-color: yellowgreen;">
        <h2>Slide 1</h2>
      </div>

      <div class="swiper-slide" style="background-color: violet;">
        <h2>Slide 2</h2>
      </div>

      <div class="swiper-slide" style="background-color: peru;">
        <h2>Slide 3</h2>
      </div>

      <div class="swiper-slide" style="background-color: lightblue;">
        <h2>Slide 4</h2>
      </div>

      <div class="swiper-slide" style="background-color: orangered;">
        <h2>Slide 5</h2>
      </div>

      <div class="swiper-slide" style="background-color: pink;">
        <h2>Slide 6</h2>
      </div>


    </div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev" id="swiper_button_prev_test_slider_1"><span
        class="sr-only">Předchozí</span></div>
    <div class="swiper-button-next" id="swiper_button_next_test_slider_1"><span
        class="sr-only">Následující</span></div>
    <div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_test_slider_1">
    </div>
  </div>
</section>