{capture assign=url}{link_to action="articles/detail" id=$article}{/capture}

{assign type "{t}Article{/t}"}
{if $article->getPrimaryTag()}{assign type $article->getPrimaryTag()->getTagLocalized()|capitalize}{/if}

{if $article->getTeaser()}
	{assign subtitle $article->getTeaser()|markdown|strip_html|truncate:100}
{else}
	{assign subtitle $article->getBody()|markdown|strip_html|truncate:100}
{/if}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$article->getImageUrl()
	url=$url
	type=$type
	title=$article->getTitle()
	subtitle=$subtitle
}
