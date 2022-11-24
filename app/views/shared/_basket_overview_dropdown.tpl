<div class="basket-overview-dropdown dropdown-menu dropdown-menu-right js--basket-overview-dropdown">
  <div class="basket-overview-dropdown__inner js--basket-overview-dropdown__inner">
    <div class="basket-overview-dropdown__content">
      {render partial="shared/basket_overview_dropdown_content"}
    </div>
    <div class="basket-overview-dropdown__loader">
      <div class="spinner-border text-secondary" role="status">
        <span class="sr-only">Loading...</span>
      </div>      
    </div>
    <div class="basket-overview-dropdown__footer">
      <a href="{link_to namespace="" action="baskets/edit"}" class="btn btn-primary">{!"shopping-cart"|icon} {t}Košík{/t} {!"angle-right"|icon}</a>
    </div>
  </div>
</div>