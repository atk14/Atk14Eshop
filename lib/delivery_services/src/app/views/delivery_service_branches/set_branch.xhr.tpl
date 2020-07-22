$("#delivery_service_branch_select").remove();

var $modal = $({jstring}{modal id=delivery_service_branch_select title="{$page_title}"}
{render partial="set_branch_form"}
{/modal}{/jstring});

$modal.appendTo("body");
$("#delivery_service_branch_select").modal("show");

$("#atk14-widget-zasilkovna").Zasilkovna( { target_input_id: "id_delivery_service_branch_id" });
