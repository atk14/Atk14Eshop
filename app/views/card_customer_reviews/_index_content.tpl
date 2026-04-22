{assign product_type $card->getProductType()}

<div class="customer-reviews">
{if $rating}
	<div class="customer-reviews__wrap">
		<div class="customer-reviews__ratings">
			<strong class="h1">{$rating|format_number:1}</strong><br>
			{render partial="shared/customer_review/stars" rating=$rating}<br>
			{if $review_count==1}
				{t}Based on one review{/t}
			{else}
				{t review_count=$review_count}Based on %1 reviews{/t}
			{/if}

			<div class="py-4">
			{a_remote action="customer_reviews/create_new" card_id=$card _class="btn btn-primary"}{!"pen"|icon} {t}Write review{/t}{/a_remote}
			</div>

			<ul class="customer-ratings__breakdown">
				{foreach $star_rows as $star_row}
					<li>
						<span class="breakdown__numberstars">
							<span>{$star_row->getStars()}</span>
							<span>{!"star"|icon}</span>
						</span>
						<div class="progress">
							<div class="progress-bar" role="progressbar" style="width: {$star_row->getPercentage()|round}%" aria-valuenow="{$star_row->getPercentage()|round}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span>{$star_row->getStarCount()} &times;</span>
					</li>
				{/foreach}
			</ul>
		</div>
		{if $customer_reviews}
			<div class="customer-reviews__reviews">
				<h2>{t}Customer reviews{/t}</h2>
				{render partial="shared/customer_review" from=$customer_reviews item=customer_review}
			</div>
		{/if}
	</div>

{else}
	
	{render partial="shared/customer_review/stars" rating=null}<br>

	<p>
		{if in_array($product_type->getCode(),["book","ebook"])}
			{t}No one has rated this book yet.{/t}
		{else}
			{t}No one has rated this product yet.{/t}
		{/if}
	</p>

	{a_remote action="customer_reviews/create_new" card_id=$card _class="btn btn-primary"}{!"pen"|icon} {t}Write review{/t}{/a_remote}

{/if}
</div>
