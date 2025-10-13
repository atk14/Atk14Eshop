{*
 * {render partial="shared/product_image" product=$product}
 * {render partial="shared/product_image" product=$product image_size=80}
 * {render partial="shared/product_image" product=$product image_width=400 image_height=300}
 * {render partial="shared/product_image" product=$product image_class="img-fluid"}
 * {render partial="shared/product_image" product=$product image_class="img-fluid" image_style="aspect-ratio: 1.3333;"}
 *}

{if $image_width}
	{assign image_size $image_width}
{/if}

{if $image_height && !$image_width}
	{assign image_size $image_height}
{/if}

{if !$image_size}
	{assign image_size 120}
{/if}

{if !$image_width}{assign image_width $image_size}{/if}
{if !$image_height}{assign image_height $image_size}{/if}

{if $product && $product->getImage()}
	<img {!$product->getImage()|img_attrs:"{$image_width}x{$image_height}x#ffffff"} alt=""{if $image_class} class="{$image_class}"{/if}{if $image_style} style="{$image_style}"{/if}>
{else}
	{assign replacement_url "{$public}images/camera.svg"}
	<img src="{$replacement_url}" width="{$image_width}" height="{$image_height}" alt=""{if $image_class} class="{$image_class}"{/if}{if $image_style} style="{$image_style}"{/if}>
{/if}
