$("#basket_modal_dialog").remove();
$(".modal-backdrop").remove();

var $modal = $({jstring}{modal id=basket_modal_dialog title="{t}Select variant{/t}"}
	{render partial="select_variant"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#basket_modal_dialog").modal("show");
