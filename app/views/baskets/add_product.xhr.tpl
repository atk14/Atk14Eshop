{capture assign=offcanvas_content}
<div class="basket-content__text">
	{render partial="product_added" hide_buttons=true}
</div>	
{render partial="offcanvas_basket_items"}
{/capture}
$( ".js--basket_info_content" ).replaceWith({jstring}{render partial="shared/basket_info_content" was_changed=true}{/jstring});
window.basketOffcanvas.showCustomBasket( {jstring}{!$offcanvas_content}{/jstring}, 0 );