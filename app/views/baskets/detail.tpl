{render partial="shared/offcanvas_basket/detail"}

{javascript_tag}
	$( ".js--basket_info_content" ).replaceWith({jstring}{render partial="shared/basket_info_content"}{/jstring});
{/javascript_tag}
