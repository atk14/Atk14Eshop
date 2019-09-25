{assign first_image 1}

<section class="product-gallery product-gallery--normal">

	<div class="gallery__images">

	{if $card->hasVariants()}
		{assign products $card->getProducts()}
		{foreach $products as $product}
			{assign image $product->getImage(false)}
			{if $image}
				{assign geom $geometry_thumbnail}
				{assign itemClass ""}
				{if $first_image}
					{assign geom $geometry_detail}
					{assign itemClass "gallery__item--first"}
					{assign first_image 0}
				{/if}
				{render partial="gallery/item" image=$image geometry_detail=$geometry_detail geometry=$geom product=null itemClass=$itemClass}
			{/if}	
		{/foreach}
	{/if}

	{foreach $card->getImages(false) as $image}
		{assign geom $geometry_thumbnail}
		{assign itemClass ""}
		{if $first_image}
			{assign geom $geometry_detail}
			{assign itemClass "gallery__item--first"}
			{assign first_image 0}
		{/if}
		{render partial="gallery/item" image=$image geometry_detail=$geometry_detail geometry=$geom product=null itemClass=$itemClass}
	{/foreach}

	</div>
</section>
