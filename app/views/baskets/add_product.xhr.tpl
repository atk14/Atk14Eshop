{capture assign=offcanvas_content}
<div class="p-2">
	{render partial="product_added" hide_buttons=true}
</div>	
{render partial="offcanvas_basket_items"}
{/capture}
console.log( "added");
$( ".js--basket_info_content" ).replaceWith({jstring}{render partial="shared/basket_info_content" was_changed=true}{/jstring});
window.basketOffcanvas.showCustomBasket( {jstring}{!$offcanvas_content}{/jstring}, 0 );