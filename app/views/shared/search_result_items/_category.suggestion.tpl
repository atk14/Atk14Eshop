{capture assign=url}{link_to action="categories/detail" path=$category->getPath()}{/capture}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$category->getImageUrl()
	url=$url
	type="{t}Kategorie produktů{/t}"
	title=$category->getLongName()
	price_info=$price_info
}
