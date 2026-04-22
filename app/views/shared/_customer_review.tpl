<div class="customer-reviews__review">
	<div class="review__content">
		{if $image}
		<div class="review__image">
			{!$image}
		</div>
		{/if}
		<div class="review__body">
			{if $dropdown_menu}{!$dropdown_menu}{/if}
			{if $product_name}<h3 class="mb-4">{!$product_name}</h3>{/if}
			<p class="review__meta">
				{if $customer_review->getAuthor()|strlen}<strong>{$customer_review->getAuthor()}</strong> |&nbsp;{/if}<span class="sr-only">{t}created at:{/t}</span>{$customer_review->getCreatedAt()|format_date}<br>
				{render partial="shared/customer_review/stars" rating=$customer_review->getRating()}
			</p>
			{if $customer_review->getTitle()}<h4>{$customer_review->getTitle()}</h4>{/if}
			<p>{!$customer_review->getBody()|remove_empty_lines:"max_empty_lines=1"|h|nl2br}</p>
			{if $footnote}<div class="text-muted">{!$footnote}</div>{/if}
		</div>
	</div>
</div>
