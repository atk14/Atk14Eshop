{capture assign=url}{link_to action="cards/detail" id=$card}{/capture}
{capture assign=default_price_label}{if $card->getProductType()->getCode()!="product"}{$card->getProductType()|lower}{/if}{/capture}
{capture assign=price_info}{render partial="shared/card_price" card=$card default_price_label=$default_price_label}{/capture}
{assign main_creators CardCreator::GetMainCreatorsForCard($card)}
{assign subtitle ""}
{if $main_creators}
	{capture assign="subtitle"}{$main_creators|to_sentence:", "}{/capture}
{else}
	{capture assign=subtitle}{$card->getTeaser()|markdown|strip_html|truncate:100}{/capture}
{/if}

{capture assign=class}search-suggestions-list__item--card--id-{$card->getId()}{if $basket->contains($card)} search-suggestions-list__item--card--in-basket{/if}{/capture}

{capture assign=icons}{if $favourite_products_accessor->isFavouriteCard($card)}<span class="card-icon card-icon--favourite" title="{t}Your favourite product{/t}">{!"heart"|icon}</span>{/if}{/capture}

{render partial="shared/search_result_items/generic_template.suggestion"
	image_url=$card->getImage()
	url=$url
	type=""
	title=$card->getName()
	price_info=$price_info
	class=$class
	flags=$flags
}
