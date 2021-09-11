{dropdown_menu clearfix=false}
	<a href="{$product|link_to_product}">{!"eye"|icon} {t}Show on web{/t}</a>
	{render partial="cards/product_menu_links" product=$product display_dividers=0}
{/dropdown_menu}

<h1>{$page_title}</h1>

{render partial="shared/form"}

<hr>

{render partial="shared/image_gallery" object=$product}
