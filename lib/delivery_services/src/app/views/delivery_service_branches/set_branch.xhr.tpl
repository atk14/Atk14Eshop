{assign delivery_service $delivery_method->getDeliveryService()}
{assign zasilkovna $delivery_service && $delivery_service->getCode()=="zasilkovna"}
{assign gls $delivery_service && $delivery_service->getCode()=="gls"}
{assign cp_balikovna $delivery_service && $delivery_service->getCode()=="cp-balikovna"}

{assign modal_title $page_title}
{if $zasilkovna}{assign modal_title ""}{/if}

$("#delivery_service_branch_select").remove();


var $modal = $({jstring}{modal id=delivery_service_branch_select title=$modal_title close_button=!$zasilkovna}
	{render partial="set_branch_form"}
{/modal}{/jstring});

{if $zasilkovna || $gls}
$modal.addClass("modal--zasilkovna");
{/if}
$modal.appendTo("body");
$("#delivery_service_branch_select").modal("show");

{if $zasilkovna}
  {render partial="widget_js_zasilkovna"}
{/if}

{if $gls}
  {render partial="widget_js_gls"}
{/if}

{if $cp_balikovna}
  {render partial="widget_js_cp_balikovna"}
{/if}
