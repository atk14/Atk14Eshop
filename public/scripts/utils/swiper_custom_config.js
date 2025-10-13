/**
 * Customs configurations for slider created by utils/swiper.js
 * Useful for cases when data attributes are uncapable to express desired options such as breakpoints configuration etc.
 * Options set in customSliderCofiguration[custom config name] will override any calculated swiper options
 * 
 * Usage via data-custom_config attribute:
 * <div class="swiper" data-slides_per_view="1" data-loop="true" data-autoplay="6000" data-slider_id="dfss45445e" id="swiper_dfss45445e" data-spacebetween="20" data-custom_config="sliderCards">
 * 
 */

window.UTILS = window.UTILS || { };

window.UTILS.customSliderCofiguration = {
  sliderCards: {
    breakpoints: {
      980: {
        slidesPerView: 2,
        slidesPerGroup: 2,
      },
      10: {
        slidesPerView: 1,
        slidesPerGroup: 1,
      },
    }
  }
};