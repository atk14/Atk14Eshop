{assign first_image 1}

<section class="photo-gallery photo-gallery--product product-gallery product-gallery--no-variants">

	<div class="gallery__images">

	{foreach $card->getImages(false) as $image}
		{assign geom $geometry_thumbnail}
		{assign itemClass ""}
		{if $first_image}
			{assign geom $geometry_preview}
			{assign first_image 0}
		{/if}
		{render partial="gallery/item" image=$image geometry_detail=$geometry_detail geometry=$geom product=null itemClass=$itemClass}
	{/foreach}

	</div>
</section>
