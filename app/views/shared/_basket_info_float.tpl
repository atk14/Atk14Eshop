{assign incl_vat $basket->displayPricesInclVat()}

<a href="{link_to namespace="" action="baskets/edit"}" class="js--basket_info_float" rel="nofollow">
  <span class="cart__icon">{!"shopping-cart"|icon}</span>
  {if !$basket->isEmpty()}
  {assign currency $basket->getCurrency()}
  <span class="cart-num-items">{$basket->getItems()|sizeof}</span>
  <div class="cart__price">{!$basket->getItemsPrice($incl_vat)|display_price:"$currency,summary"}</div>
  {/if}
</a>
