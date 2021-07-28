{*
 * {render partial="shared/product_image" product=$product}
 * {render partial="shared/product_image" product=$product image_size=80}
 *}

{if !isset($image_size)}
	{assign image_size 120}
{/if}

{if $product && $product->getImage()}
	<img {!$product->getImage()|img_attrs:"{$image_size}x{$image_size}x#ffffff"} alt="">
{else}
	<img src="{$public}images/camera.svg" width="{$image_size}" height="{$image_size}">
{/if}
