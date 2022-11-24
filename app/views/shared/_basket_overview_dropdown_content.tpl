{if !$basket->isEmpty()}
  <div class="basket-overview-dropdown__items">
    <table>
      <tbody>
        {for $foo=1 to 8}
          <tr class="item">
            <td class="item__image">
              <img src="https://placekitten.com/50/50" width="50" height="50" alt="">
            </td>
            <td class="item__name">
              Product name
            </td>
            <td class="item__quantity">
              2&nbsp;ks
            </td>
            <td class="item__price">
              358&nbsp;Kč
            </td>
          </tr>
        {/for}
      </tbody>
    </table>
  </div>
  <div class="basket-overview-dropdown__total">
    <span class="basket-overview-dropdown__total__title">{t}Celkem{/t}</span>
    <span class="basket-overview-dropdown__total__price">1 235 Kč</span>
  </div>
{else}
  <div class="basket-overview-dropdown__empty">
    {t}The shopping basket is empty.{/t}
  </div>
{/if}