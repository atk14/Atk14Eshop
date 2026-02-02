$("#card_customer_reviews_modal_id").remove();
$("#customer_review_creation_modal_id").remove();
$(".modal-backdrop").remove();

var $modal = $({jstring}{modal id=customer_review_creation_modal_id title=$modal_title}
	{render partial="create_new/product_cant_be_reviewed_content"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#customer_review_creation_modal_id").modal("show");
