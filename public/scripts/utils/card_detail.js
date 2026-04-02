/**
 * Card detail utilities - total price update after quantity change, switching variants
 * 
 * Usage:
 * window.UTILS.initCardDetail();
 * 
 */

window.UTILS = window.UTILS || { };

window.UTILS.initCardDetail = function() {
  // Update celkove ceny pri zmene mnozstvi
  var qtyInput = $( ".js-quantity-widget .js-quantity-input" );
  qtyInput.on( "change", function() {
    var qtyWidget = $( this ).closest( ".js-quantity-widget" );
    var qty = parseInt( $( this ).val() );
    var unitPrice = parseFloat( qtyWidget.data( "unitprice" ) );
    var totalPrice = qty * unitPrice;
    var totalPriceNice = totalPrice.toFixed(2).replace( ".", "," );
    qtyWidget.find( ".js-quantity-total-price" ).html( totalPriceNice + "&nbsp;Kč" );
    qtyWidget.find( ".js-quantity-suffix" ).css( "display", "inline" );
  } );

  // Prepnuti varianty produktu
  $( "#variants-nav a[data-product_id]" ).on( "click", function() {
    var $link = $( this ),
      productId = $link.data( "product_id" ),
      $galleryItem = $( ".product-gallery--with-variants .gallery__item[data-product_id=" + productId + "]" ).eq( 0 ),
      $preview = $( ".product-gallery .js_gallery_trigger a" ),
      $previewImage = $preview.find( "img" );
    if ( !$galleryItem ) { return; }
    $preview.data( "preview_for" , $galleryItem.data( "id" ) );
    $preview.attr( "data-preview_for" , $galleryItem.data( "id" ) );
    $previewImage.attr( "src", $galleryItem.data( "preview_image_url" ) );
    $previewImage.attr( "width", $galleryItem.data( "preview_image_width" ) );
    $previewImage.attr( "height", $galleryItem.data( "preview_image_height" ) );
  } );
};