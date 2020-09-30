{capture assign=url}{link_to action="stores/detail" id=$store}{/capture}
{assign subtitle ""}
{if $store->isOpen()}{capture assign=subtitle}{t}právě otevřeno{/t}{/capture}{/if}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$store->getImageUrl()
	url=$url
	type="{t}Prodejna{/t}"
	title=$store->getName()
	subtitle=$subtitle
	price_info=$price_info
}
