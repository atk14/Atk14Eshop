{*
 * Photo gallery, ready to use Photoswipe
 * Usage:
 *
 *	{render partial="shared/photo_gallery" object=$brand}
 *	{render partial="shared/photo_gallery" object=$brand compact=true}
 *	or
 *	{render partial="shared/photo_gallery" images=$object->getImages()}
		
 *}

{if !$images && $object}
	{assign var=images value=Image::GetImages($object)}
{/if}
{assign geometry_detail "1800"}

{if $images}
	{if !isset($photo_gallery_title)}{capture assign="photo_gallery_title"}{t}Photo gallery{/t}{/capture}{/if}
	<section class="photo-gallery photo-gallery--product">
		<div class="gallery__images">
			{foreach $images as $image}
				{* first image shoud be bigger*}
				{if $image@iteration==1}
					{assign imgAtts "680x"}
				{else}
					{assign imgAtts "x100"}
				{/if}
				<figure class="gallery__item">
					<a href="{$image|img_url:$geometry_detail}" title="{if $image->getDescription()}{$image->getDescription()}{/if}" data-size="{$image|img_width:$geometry_detail}x{$image|img_height:$geometry_detail}">
						<img {!$image|img_attrs:$imgAtts} alt="{$image->getName()}" class="">
					</a>
					<figcaption>
						<div><strong>{$image->getName()}</strong></div>
						<div>{$image->getDescription()}</div>
					</figcaption>
			</figure>
			{/foreach}
		</div>
		{if $photo_gallery_title}
		{/if}
	</section>
{/if}
