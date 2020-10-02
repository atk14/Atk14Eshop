{capture assign=url}{link_to action="cards/detail" id=$card}{/capture}
{capture assign=price_info}{render partial="shared/card_price" card=$card}{/capture}
{assign main_creators CardCreator::GetMainCreatorsForCard($card)}
{assign subtitle ""}
{if $main_creators}
	{capture assign="subtitle"}{$main_creators|to_sentence}{/capture}
{/if}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$card->getImage()
	url=$url
	type=$card->getProductType()|capitalize
	title=$card->getName()
	price_info=$price_info
}
