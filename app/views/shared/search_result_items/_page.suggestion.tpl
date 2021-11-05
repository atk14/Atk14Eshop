{capture assign=url}{link_to action="pages/detail" id=$page}{/capture}
{assign type "{t}Informace{/t}"}

{if Creator::FindFirst("page_id",$page)}
	{assign type "{t}Profil{/t}"}
{/if}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$page->getImageUrl()
	url=$url
	type=$type
	title=$page->getTitle()
	subtitle=$page->getTeaser()|markdown|strip_html|truncate:100
}
