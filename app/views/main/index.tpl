{render partial="shared/slider" slider=$slider}


{if $category_recommended_cards}
	{admin_menu for=$category_recommended_cards}
	{render partial="shared/layout/content_header" title=$category_recommended_cards->getName() teaser=$category_recommended_cards->getTeaser()|markdown tag="h2"}
	
	{if $category_recommended_cards->getDescription()}
		{!$category_recommended_cards->getDescription()|markdown}
	{/if}
	
	{render partial="shared/card_list" cards=$category_recommended_cards->getCards() title=""}
{/if}

<article>

	{if $page}
	
		{render partial="shared/layout/content_header" title=$page->getTitle() teaser=$page->getTeaser()|markdown tag="h2"}
		
		<div class="row">
			<div class="col-12 col-md-7 col-lg-6">
				{!$page->getBody()|markdown}
			</div>
			{if $recent_articles}
				{foreach $recent_articles as $article}
					<div class="col-12 col-md-5 col-lg-6">
						<a href="{link_to action="articles/detail" id=$article}" class="banner banner--image-text--halfwidth">
							<img src="{$article->getImageUrl()|img_url:"400x300"}" class="banner__image img-fluid" alt="">
							<div class="banner__text">{$article->getTitle()}</div>
						</a>
					</div>
				{/foreach}
			{/if}
		</div>
	{else}
		{render partial="shared/layout/content_header" title=$page_title}
	{/if}

</article>
	
{if $page  && !$page->isIndexable()}
	{content for=head}
		<meta name="robots" content="noindex,noarchive">
	{/content}
{/if}
