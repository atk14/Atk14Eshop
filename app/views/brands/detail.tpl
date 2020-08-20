{admin_menu for=$brand}
{render partial="shared/layout/content_header" title=$page_title teaser=$brand->getTeaser()|markdown brand="" image=$brand->getLogoUrl()|img_url:"800x,format=png" image_is_logo=true}

<section class="border-top-0">
	{!$brand->getDescription()|markdown}
</section>

{render partial="shared/photo_gallery" object=$brand}

{render partial="shared/card_list" cards=$brand->getCards()}
