{assign incl_vat $basket->displayPricesInclVat()}
{assign currency $basket->getCurrency()}
<div class="basket-content__items" data-items-count="{$basket->getItems()|count}">
  <table class="table--offcanvas-basket">
    <tbody>
      {foreach $basket->getItems() as $item}
      {assign product $item->getProduct()}
      {assign unit $product->getUnit()}
      {assign price $item->getProductPrice()}
      <tr class="item">
        <td class="item__image">
          <a href="{$product|link_to_product}">
            <img {!$product->getImage()|img_attrs:"80x80x#ffffff"}></td>
          </a>
        <td class="item__name">
          <a href="{$product|link_to_product}">{$product->getName()}</a>
        </td>
        <td class="item__quantity">{$item->getAmount()} {$unit}</td>
        <td class="item__price">{render partial="price" price=$price}</td>
      </tr>
      {/foreach}
    </tbody>
  </table>
</div>
<div class="basket-content__total">
  <div class="description">{t}Total price{/t}:</div>
  <div class="price">{!$basket->getItemsPrice($incl_vat)|display_price:"$currency,summary"}</div>
</div>	