{capture assign=url}{link_to action="pages/detail" id=$page}{/capture}
{assign type "{t}Stránka{/t}"}

{if Creator::FindFirst("page_id",$page)}
	{assign type "{t}Tvůrce{/t}"}
{/if}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$page->getImageUrl()
	url=$url
	type=$type
	title=$page->getTitle()
}
