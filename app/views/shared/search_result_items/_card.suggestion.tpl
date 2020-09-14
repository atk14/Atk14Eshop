{capture assign=url}{link_to action="cards/detail" id=$card}{/capture}
{capture assign=price_info}{render partial="shared/card_price" card=$card}{/capture}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$card->getImage()
	url=$url
	type=$card->getProductType()|capitalize
	title=$card->getName()
	price_info=$price_info
}
