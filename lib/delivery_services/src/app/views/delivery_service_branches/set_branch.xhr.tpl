$("#delivery_service_branch_select").remove();

var $modal = $({jstring}{modal id=delivery_service_branch_select title="{$page_title}"}
{render partial="shared/form"}
{/modal}{/jstring});

$modal.appendTo("body");
$("#delivery_service_branch_select").modal("show");

// jak to navesit automaticky ??
UTILS.handleSuggestions();
//UTILS.deliveryServiceBranchSelector.init();
