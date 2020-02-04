{admin_menu for=$collection}
{render partial="shared/layout/content_header" title=$page_title teaser=$collection->getTeaser()|markdown image=$collection->getImageUrl()}

<section class="border-top-0">
	{!$collection->getDescription()|markdown}
</section>

{render partial="shared/photo_gallery" object=$collection}

{capture assign=title}{t collection=$collection->getName()}Products in the collection %1{/t}{/capture}
{render partial="shared/card_list" cards=$collection->getCards() title=$title}
