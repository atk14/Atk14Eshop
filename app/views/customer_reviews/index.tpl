{render partial="shared/layout/content_header" title=$page_title}


{*
{!$order_items|dump}
*}

{if $review_candidates}
	<h2 class="mb-4">{t}Write a review for the product you purchased{/t}</h2>

	<div class="section--list-products">
		<div class="card-deck card-deck--sized-6">
			{assign geometry "400x570"}
			{foreach $review_candidates as $review_candidate}
				{assign product $review_candidate->getProduct()}
				{assign card $product->getCard()}
				<div class="card">
					<a class="card__image card__image--book" href="{link_to namespace="" action="cards/detail" id=$card}">
						{if $card->getImage()}
						<picture>
							<source srcset="{$card->getImage()|img_url:"`$geometry`,format=webp"}" width="{$card->getImage()|img_width:"`$geometry`,format=webp"}" height="{$card->getImage()|img_height:"`$geometry`,format=webp"}" type="image/webp">
							<source srcset="{$card->getImage()|img_url:"`$geometry`,format=jpg"}" width="{$card->getImage()|img_width:"`$geometry`,format=jpg"}" height="{$card->getImage()|img_height:"`$geometry`,format=jpg"}"  type="image/jpeg">
							<img {!$card->getImage()|img_attrs:$geometry} alt="{$card->getName()}">
						</picture>
						{else}
							<img src="{$public}dist/images/default_image_blue_400x570.svg" width="400" height="570" title="{t}no image{/t}" alt="{t}no image{/t}" class="card-img-top default-image">
						{/if}
					</a>
					<div class="card-body">
						<a class="card-title h4" href="{link_to namespace="" action="cards/detail" id=$card}">{$card->getName()}</a>
					</div>
					<div class="card-footer d-block">
						<div class="card-footer__meta text-left">
							{t date=$review_candidate->getPurchasedAt()|format_date}Purchased at %1{/t}
						</div>
						{a_remote action="customer_reviews/create_new" product_id=$review_candidate->getProduct() _class="btn btn-outline-primary"}{!"edit"|icon} {t}Write review{/t}{/a_remote}
					</div>
				</div>
			{/foreach}
		</div>
	</div>
{/if}

{if $review_candidate}
	<h2 class="mb-4">{t}My reviews{/t}</h2>
{/if}

{if $reviews}
	<div class="customer-reviews">
		{foreach $reviews as $review}
			{assign product $review->getProduct()}
			{capture assign="product_name"}<a href="{$product|link_to_product}">{$product->getName()}</a>{/capture}
			{capture assign="product_image"}<a href="{$product|link_to_product}" aria-label="{$product->getName()} - {t}Product detail{/t}">{render partial="shared/product_image" product=$product}</a>{/capture}
			{if $review->getBody()|strlen && !$review->isPublished()}
				{capture assign="footnote"}{!"triangle-exclamation"|icon} {t}This review has not yet been published{/t}{/capture}
			{else}
				{assign "footnote" 0}
			{/if}
			{capture assign="dropdown_menu"}	
			{dropdown_menu clearfix=false}
				{a_remote action="customer_reviews/create_new" product_id=$review->getProductId()}{!"edit"|icon} {t}Edit{/t}{/a_remote}
				{a_destroy id=$review}{!"remove"|icon} {t}Delete review{/t}{/a_destroy}
			{/dropdown_menu}
			{/capture}
			{render partial="shared/customer_review" customer_review=$review product_name=$product_name footnote=$footnote image=$product_image}
		{/foreach}
	</div>
{else}
	{if !$review_candidates}
		<p>{t}The option to write a review will be available to you based on your purchases.{/t}</p>
	{else}
		<p>{t}You haven't written any reviews yet.{/t}</p>
	{/if}
{/if}
