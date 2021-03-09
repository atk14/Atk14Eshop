{assign delivery_service $delivery_method->getDeliveryService()}

$("#delivery_service_branch_select").remove();

var $modal = $({jstring}{modal id=delivery_service_branch_select title="{$page_title}" close_button={!$delivery_service || $delivery_service->getCode()!="zasilkovna"}}
{render partial="set_branch_form"}
{/modal}{/jstring});

{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
$modal.addClass("modal--zasilkovna");
{/if}
$modal.appendTo("body");
$("#delivery_service_branch_select").modal("show");

{if $delivery_service && $delivery_service->getCode()=="zasilkovna"}
$("#atk14-widget-zasilkovna").Zasilkovna( { target_input_id: "id_delivery_service_branch_id" });
{/if}
