{admin_menu for=$brand}
{render partial="shared/layout/content_header" title=$page_title teaser=$brand->getTeaser()|markdown image=$brand->getLogoUrl()}

<section class="border-top-0">
	{!$brand->getDescription()|markdown}
</section>

{render partial="shared/photo_gallery" object=$brand}

{render partial="shared/card_list" cards=$brand->getCards()}
