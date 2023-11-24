{assign delivery_service $delivery_method->getDeliveryService()}
{assign zasilkovna $delivery_service && $delivery_service->getCode()=="zasilkovna"}
{if $dialog_provider=="default"}
	{assign class ""}
{else}
	{assign class "modal--pickup_point"}
{/if}

{assign modal_title $page_title}
{if $zasilkovna}{assign modal_title ""}{/if}

$("#delivery_service_branch_select").remove();

var $modal = $({jstring}{modal id=delivery_service_branch_select title=$modal_title close_button=!$zasilkovna class=$class}
	{render partial="set_branch_form"}
{/modal}{/jstring});

$modal.appendTo("body");
$("#delivery_service_branch_select").modal("show");

{if $delivery_service}
	{render partial=$widget_template_js}
{/if}

{if $dialog_provider=="default"}
window.UTILS.searchSuggestion( "js--delivery_branch_search_input", "js--delivery_branch_suggesting_area" );
{/if}
