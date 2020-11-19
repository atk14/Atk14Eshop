{capture assign=url}{link_to action="articles/detail" id=$article}{/capture}

{assign type "{t}Article{/t}"}
{if $article->getPrimaryTag()}{assign type $article->getPrimaryTag()->getTagLocalized()|capitalize}{/if}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$article->getImageUrl()
	url=$url
	type=$type
	title=$article->getTitle()
}
