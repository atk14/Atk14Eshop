import PhotoSwipeLightbox from "/public/dist/scripts/modules/photoswipe-lightbox.esm.min.js";

// Initialize PhotoSwipe
const lightbox = new PhotoSwipeLightbox({
  gallery: ".gallery__images, .iobject--picture",
  // Instead of just "figure a[data-pswp-width]" more complex selector is needed to exclude images in Swiper duplicated slides
  //children: ".gallery__images > figure a[data-pswp-width], .iobject--picture  > figure a[data-pswp-width], *:not(.swiper-slide-duplicate) > figure a[data-pswp-width]",
  children: "figure a[data-pswp-width]",
  pswpModule: () => import("/public/dist/scripts/modules/photoswipe.esm.min.js")
});
console.log(lightbox);

// Get image titles and captions
lightbox.on('uiRegister', function() {
  console.log( "uiRegister" );
  lightbox.pswp.ui.registerElement({
    name: 'custom-caption',
    order: 9,
    isButton: false,
    appendTo: 'root',
    html: '',
    onInit: (el, pswp) => {
      console.log( "onInit" );
      lightbox.pswp.on('change', () => {
        console.log( "change" );
        const currSlideElement = lightbox.pswp.currSlide.data.element;
        const parentFigure = currSlideElement.closest( "figure" );
        const figcaption = parentFigure.querySelector( "figcaption" );
        console.log( currSlideElement.closest( "figure" ).querySelector( "figcaption" ) );
        let captionHTML = '';
        if (currSlideElement) {
          const hiddenCaption = currSlideElement.querySelector('.hidden-caption-content');
          // get caption from alt attribute
          // captionHTML = currSlideElement.querySelector('img').getAttribute('alt');
          // Get caption from figcaption tag
          console.log( "figcation", figcaption );
          if( figcaption ) {
            captionHTML = figcaption.innerHTML;
          }
        }
        el.innerHTML = captionHTML || '';
      });
    }
  });
});

lightbox.init();

// Trigger gallery from other links 
// Used in gallery on product with variants
// and in swiper slider gallery to prevent issues with duplicated slides
var galleryTriggers = document.querySelectorAll( ".js_gallery_trigger" );
galleryTriggers.forEach( function( el ) {
  el.addEventListener( "click", function( e ) {
    var imageID = e.target.querySelector( "a[data-preview_for]" ).dataset.preview_for;
    console.log( "CLICK", imageID );
    e.preventDefault();
    if( e.target.closest( ".product-gallery" ) ) {
      // in gallery for product with variants
      console.log( "is inside product gallery" );
      var galleryLink = e.target.closest( ".product-gallery" ).querySelector( ".gallery__item[data-id=\"" + imageID + "\"] a" );
      console.log( galleryLink );
    } else {
      // other galleries
      console.log( "is NOT inside product gallery" );
    }
    // trigger click on photoswipe-ready link
    if( galleryLink ) {
      galleryLink.click();
    }
  } );
} );

