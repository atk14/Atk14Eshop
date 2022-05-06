import PhotoSwipeLightbox from "/public/dist/scripts/modules/photoswipe-lightbox.esm.min.js";

const lightbox = new PhotoSwipeLightbox({
  gallery: ".gallery__images, .iobject--picture",
  children: "figure a[data-pswp-width]",
  pswpModule: () => import("/public/dist/scripts/modules/photoswipe.esm.min.js")
});
console.log(lightbox);
lightbox.init();