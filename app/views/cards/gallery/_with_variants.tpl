{assign first_image 1}
{assign products $card->getProducts()}

<section class="photo-gallery photo-gallery--product product-gallery product-gallery--with-variants">

	{placeholder for=gallery_preview}
	
	<div class="gallery__images" itemscope itemtype="http://schema.org/ImageGallery">

	{* Display only the preview image of the $current_product *}
	{foreach $products as $product}
		{if $product->getId()==$current_product->getId()}
			{assign image $product->getImage(false)}
			{if $image}
				{if $first_image}
					{render partial="gallery/preview" image=$image geometry_detail=$geometry_detail geometry=$geometry_preview}
					{assign first_image 0}
				{/if}
			{/if}	
		{/if}
	{/foreach}

	{* Display all product images *}
	{foreach $products as $product}
		{assign image $product->getImage(false)}
		{if $image}
			{if $first_image}
				{render partial="gallery/preview" image=$image geometry_detail=$geometry_detail geometry=$geometry_preview}
				{assign first_image 0}
			{/if}
			{render partial="gallery/item" image=$image geometry_detail=$geometry_detail geometry=$geometry_thumbnail product=$product preview_image_url=$image|img_url:$geometry_preview preview_image_width=$image|img_width:$geometry_preview preview_image_height=$image|img_height:$geometry_preview}
		{/if}	
	{/foreach}

	{* Display card images *}
	{foreach $card->getImages(false) as $image}
		{if $first_image}
			{render partial="gallery/preview" image=$image geometry_detail=$geometry_detail geometry=$geometry_preview}
			{assign first_image 0}
		{/if}
		{render partial="gallery/item" image=$image geometry_detail=$geometry_detail geometry=$geometry_thumbnail product=null}
	{/foreach}

	</div>
</section>
