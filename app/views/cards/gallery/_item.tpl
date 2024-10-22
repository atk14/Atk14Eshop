<figure class="gallery__item{if $itemClass} {$itemClass}{/if}" data-id="{$image->getId()}"{if $product} data-product_id="{$product->getId()}"{/if}{if $preview_image_url} data-preview_image_url="{$preview_image_url}" data-preview_image_width="{$preview_image_width}" data-preview_image_height="{$preview_image_height}"{/if} itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
	<a href="{$image|img_url:$geometry_detail}" title="{if $image->getDescription()}{$image->getDescription()}{/if}" data-size="{$image|img_width:$geometry_detail}x{$image|img_height:$geometry_detail}" itemprop="contentUrl" data-pswp-width="{$image|img_width:$geometry_detail}" data-pswp-height="{$image|img_height:$geometry_detail}" aria-label="{t}Enlarge image{/t}">
		<img {!$image|img_attrs:$geometry} alt="{$image->getName()}" class="img-fluid" itemprop="thumbnail">
	</a>
	{remove_if_contains_no_text}
	<figcaption>
		<div class="gallery-item__title"><strong>{$image->getName()}</strong></div>
		<div class="gallery-item__description">{$image->getDescription()}</div>
	</figcaption>
	{/remove_if_contains_no_text}
</figure>
