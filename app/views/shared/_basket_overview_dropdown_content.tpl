{if !$basket->isEmpty()}
  <div class="basket-overview-dropdown__items">
    <table>
      <tbody>
        {foreach $basket->getItems() as $item}
          {assign product $item->getProduct()}
          <tr class="item">
            <td class="item__image">
              {!$product->getImage()|pupiq_img:"50x50x#ffffff"}
            </td>
            <td class="item__name">
              {$product->getName()}
            </td>
            <td class="item__quantity">
              {$item->getAmount()} {t}ks{/t}
            </td>
            <td class="item__price">
              {!$item->getUnitPrice($incl_vat)|display_price:$currency}
            </td>   
          </tr>
        {/foreach}
      </tbody>
    </table>
    {*$basket->getItems()|print_r*}
  </div>
  <div class="basket-overview-dropdown__total">
    <span class="basket-overview-dropdown__total__title">{t}Celkem{/t}</span>
    <span class="basket-overview-dropdown__total__price">{!$basket->getItemsPrice($incl_vat)|display_price:"$currency,summary"}</span>
  </div>
{else}
  <div class="basket-overview-dropdown__empty">
    {t}The shopping basket is empty.{/t}
  </div>
{/if}