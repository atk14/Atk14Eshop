{assign incl_vat $basket->displayPricesInclVat()}
<a href="{link_to namespace="" action="baskets/edit"}" class="js--basket_info_float" data-toggle="offcanvas" data-target="#offcanvas-basket" aria-expanded="false" aria-controls="offcanvas-basket" aria-label="{t}Basket{/t}">
  {render partial="shared/basket_info_content"}
</a>
