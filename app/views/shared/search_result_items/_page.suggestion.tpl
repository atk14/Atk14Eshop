{capture assign=url}{link_to action="pages/detail" id=$card}{/capture}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$page->getImageUrl()
	url=$url
	type="{t}Stránka{/t}"
	title=$page->getTitle()
}
