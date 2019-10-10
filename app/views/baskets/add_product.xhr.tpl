$("#product_added_modal").remove();

var $modal = $({jstring}{modal id=product_added_modal title="{t}Produkt byl přidán do košíku{/t}"}
	{render partial="product_added"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#product_added_modal").modal("show");

{* $(".js--basket_info").replaceWith({jstring}{render partial="shared/layout/header/basket_info"}{/jstring}); *}
