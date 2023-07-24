$("#product_added_modal").remove();
$(".modal-backdrop").remove();

var $modal = $({jstring}{modal id=product_added_modal title="{t}Produkt byl přidán do košíku{/t}"}
	{render partial="product_added"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#product_added_modal").modal("show");

$( ".js--basket_info_content" ).replaceWith({jstring}{render partial="shared/basket_info_content" was_changed=true}{/jstring});
