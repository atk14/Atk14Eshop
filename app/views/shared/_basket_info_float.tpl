<a href="{link_to namespace="" action="baskets/edit"}" class="js--basket_info_float">
  <span class="cart__icon">{!"shopping-cart"|icon}</span>
  {if !$basket->isEmpty()}
  {assign currency $basket->getCurrency()}
  <span class="cart-num-items">{$basket->getItems()|sizeof}</span>
  <div class="cart__price">{!$basket->getPriceToPay()|display_price:"$currency,summary"}</div>
  {/if}
</a>
