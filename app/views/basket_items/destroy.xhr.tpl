{render partial="redraw_offcanvas_basket.xhr"}

{* There may be a different product variant in the basket *}
{if !$basket->contains($basket_item->getProduct()->getCard())}

$( ".card--id-" + {$basket_item->getProduct()->getCardId()} ).removeClass( "card--in-basket" );

{/if}
