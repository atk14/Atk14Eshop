import PhotoSwipeLightbox from "/public/dist/scripts/modules/photoswipe-lightbox.esm.min.js";

const lightbox = new PhotoSwipeLightbox({
  gallery: ".gallery__images, .iobject--picture",
  children: "figure a[data-pswp-width]",
  pswpModule: () => import("/public/dist/scripts/modules/photoswipe.esm.min.js")
});
console.log(lightbox);

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