{render partial="redraw_offcanvas_basket.xhr"}

$( ".card--id-" + {$basket_item->getProduct()->getCardId()} ).removeClass( "card--in-basket" );
