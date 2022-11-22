<div class="basket-overview-popup basket-overview-popup--loaded top">
  <div class="basket-overview-popup__content">
    {render partial="shared/basket_overview_popup_content"}
  </div>
  <div class="basket-overview-popup__loader">
    <div class="spinner-border text-secondary" role="status">
      <span class="sr-only">Loading...</span>
    </div>      
  </div>
  <div class="basket-overview-popup__footer">
    <a href="{link_to namespace="" action="baskets/edit"}" class="btn btn-primary">{!"shopping-cart"|icon} {t}Košík{/t} {!"angle-right"|icon}</a>
  </div>
</div>