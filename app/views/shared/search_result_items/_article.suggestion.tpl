{capture assign=url}{link_to action="articles/detail" id=$card}{/capture}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$article->getImageUrl()
	url=$url
	type="{t}Article{/t}"
	title=$article->getTitle()
}
