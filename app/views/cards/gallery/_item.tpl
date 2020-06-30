<figure class="gallery__item{if $itemClass} {$itemClass}{/if}" data-id="{$image->getId()}"{if $product} data-product_id="{$product->getId()}"{/if}{if $preview_image_url} data-preview_image_url="{$preview_image_url}" data-preview_image_width="{$preview_image_width}" data-preview_image_height="{$preview_image_height}"{/if} itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
	<a href="{$image|img_url:$geometry_detail}" title="{if $image->getDescription()}{$image->getDescription()}{/if}" data-size="{$image|img_width:$geometry_detail}x{$image|img_height:$geometry_detail}" itemprop="contentUrl">
		<img {!$image|img_attrs:$geometry} alt="{$image->getName()}" class="img-fluid" itemprop="thumbnail">
	</a>
	<figcaption>
		<div><strong>{$image->getName()}</strong></div>
		<div>{$image->getDescription()}</div>
	</figcaption>
</figure>
