<article>
		
	{admin_menu for=$article}
	{capture assign=article_meta}{render partial="author_and_date"}{/capture}
	{capture assign=snippet_tags}
		{foreach $tags as $tag}
			<a href="{link_to action="articles/index" tag_id=$tag}">
				{render partial="shared/tag_item" tag=$tag}
			</a>
		{/foreach}
	{/capture}
	{render partial="shared/layout/content_header" title=$article->getTitle() teaser=$article->getTeaser()|markdown tags=$snippet_tags meta=$article_meta image=$article->getImageUrl() colorbg=true}
	
	
	<section class="article__body">
		{if !$article->isPublished()}
			<p><em>{t}This is not a published article! It's not available to the public audience.{/t}</em></p>
		{/if}
		{!$article->getBody()|markdown}
	</section>
</article>

{if $older_article || $newer_article}
	<div class="pager--rich">
		{if $newer_article}
			{render partial="pager_item" pager_article=$newer_article}
		{else}
		<div></div>
		{/if}
		{if $older_article}
			{render partial="pager_item" pager_article=$older_article}
		{else}
		<div></div>
		{/if}
	</div>
{/if}
