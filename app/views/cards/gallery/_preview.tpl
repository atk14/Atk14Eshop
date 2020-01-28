{*
Used as the first image of product gallery when product has multiple variants. IMG source & attributes are changed by JS. Click on preview triggers photoswipe on small thumbnail below preview (Products without variants use _item.tpl).
*}
{content for="gallery_preview"}
<figure class="gallery__preview js_gallery_trigger">
	<a href="{$image|img_url:$geometry_detail}" title="{if $image->getDescription()}{$image->getDescription()}{/if}" data-size="{$image|img_width:$geometry_detail}x{$image|img_height:$geometry_detail}" itemprop="contentUrl" data-preview_for="{$image->getId()}">
		<img {!$image|img_attrs:$geometry_preview} alt="{$image->getName()}" class="img-fluid" itemprop="thumbnail">
	</a>
</figure>
{/content}
