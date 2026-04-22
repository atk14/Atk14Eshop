$("#card_customer_reviews_modal_id").remove();
$(".modal-backdrop").remove();

var $modal = $({jstring}{modal id=card_customer_reviews_modal_id title=$modal_title}
	{render partial="index_content"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#card_customer_reviews_modal_id").modal("show");
