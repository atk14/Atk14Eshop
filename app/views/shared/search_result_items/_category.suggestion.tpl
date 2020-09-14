{capture assign=url}{link_to action="categorys/detail" path=$category->getPath()}{/capture}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$category->getImageUrl()
	url=$url
	type="{t}Kategorie produktů{/t}"
	title=$category->getName()
	price_info=$price_info
}
