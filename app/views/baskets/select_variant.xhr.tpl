$("#product_added_modal").remove();

var $modal = $({jstring}{modal id=product_added_modal title="{t}Select variant{/t}"}
	{render partial="select_variant"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#product_added_modal").modal("show");
