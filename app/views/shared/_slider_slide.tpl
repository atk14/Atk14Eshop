{assign var=geometry_lg value="1500x500xcrop"}
{assign var=geometry_sm value="900x300xcrop"}
{assign var=geometry_sm_fullheight value="900x900xcrop"}{* h =  1 * w *}
{assign var=geometry_xs_fullheight value="900x1035xcrop"}{* h = 1.15 * w *}
{assign var=geometry_half value="900x600xcrop"}
<div class="swiper-slide slider-item-{$slide_number}">
	{if $item->getTitle() != "" || $item->getDescription() != ""}
		{* slide with both image and text *}
		<div class="swiper-slide__image">
			<picture>
				{if $item->getSmallImageUrl()}
				<source srcset="{$item->getImageUrl()|img_url:($geometry_half|cat:",format=webp")}" type="image/webp" media="(min-width: 768px)"  width="{$item->getImageUrl()|img_width:$geometry_half}" height="{$item->getImageUrl()|img_height:$geometry_half}">
				<source srcset="{$item->getImageUrl()|img_url:$geometry_half}" media="(min-width: 768px)" width="{$item->getImageUrl()|img_width:$geometry_half}" height="{$item->getImageUrl()|img_height:$geometry_half}">

				<source srcset="{$item->getSmallImageUrl()|img_url:($geometry_half|cat:",format=webp")}" type="image/webp" width="{$item->getSmallImageUrl()|img_width:$geometry_half}" height="{$item->getSmallImageUrl()|img_height:$geometry_half}">
				<source srcset="{$item->getSmallImageUrl()|img_url:$geometry_half}" width="{$item->getSmallImageUrl()|img_width:$geometry_half}" height="{$item->getSmallImageUrl()|img_height:$geometry_half}">
				{else}
					<source srcset="{$item->getImageUrl()|img_url:($geometry_half|cat:",format=webp")}" type="image/webp">
					<source srcset="{$item->getImageUrl()|img_url:$geometry_half}">
				{/if}
				<img src="{$item->getImageUrl()|img_url:$geometry_half}" class="img-fluid" alt="{$item->getTitle()}" width="{$item->getImageUrl()|img_width:$geometry_half}" height="{$item->getImageUrl()|img_height:$geometry_half}">
			</picture>
		</div>
		<div class="swiper-slide__text">
			<div>
				<h3 class="slide-title">{vlnka}{$item->getTitle()}{/vlnka}</h3>
				{if $item->getDescription()}
					<p>{vlnka}{!$item->getDescription()|h|nl2br}{/vlnka}</p>
				{/if}
			</div>
			<div>
				{if $item->getUrl()}
					<a href="{$item->getUrl()}" class="btn btn-sm btn-outline-primary">{t}Více informací{/t} <i class="fas fa-chevron-right"></i></a>
				{/if}
			</div>
		</div>
	{else}
		{* slide with image only, no text *}
		{if $item->getUrl()}
			<a href="{$item->getUrl()}" aria-label="{$item->getTitle()}">
		{/if}
			<picture>
				<source srcset="{$item->getImageUrl()|img_url:($geometry_lg|cat:",format=webp")}" media="(min-width: 768px)" type="image/webp" width="{$item->getImageUrl()|img_width:$geometry_lg}" height="{$item->getImageUrl()|img_height:$geometry_lg}">
				<source srcset="{$item->getImageUrl()|img_url:$geometry_lg}" media="(min-width: 768px)" width="{$item->getImageUrl()|img_width:$geometry_lg}" height="{$item->getImageUrl()|img_height:$geometry_lg}">
				{if $item->getSmallImageUrl()}
					<source srcset="{$item->getSmallImageUrl()|img_url:($geometry_sm_fullheight|cat:",format=webp")}" media="(min-width: 576px) and (max-width: 767px)" type="image/webp" width="{$item->getSmallImageUrl()|img_width:$geometry_sm_fullheight}" height="{$item->getSmallImageUrl()|img_height:$geometry_sm_fullheight}">
					<source srcset="{$item->getSmallImageUrl()|img_url:$geometry_sm_fullheight}" media="(min-width: 576px) and (max-width: 767px)" width="{$item->getSmallImageUrl()|img_width:$geometry_sm_fullheight}" height="{$item->getSmallImageUrl()|img_height:$geometry_sm_fullheight}">
					
					<source srcset="{$item->getSmallImageUrl()|img_url:($geometry_xs_fullheight|cat:",format=webp")}" type="image/webp" width="{$item->getSmallImageUrl()|img_width:$geometry_xs_fullheight}" height="{$item->getSmallImageUrl()|img_height:$geometry_xs_fullheight}">
					<source srcset="{$item->getSmallImageUrl()|img_url:$geometry_xs_fullheight}" width="{$item->getSmallImageUrl()|img_width:$geometry_xs_fullheight}" height="{$item->getSmallImageUrl()|img_height:$geometry_xs_fullheight}">
				{else}
					<source srcset="{$item->getImageUrl()|img_url:($geometry_sm|cat:",format=webp")}" type="image/webp" width="{$item->getImageUrl()|img_width:$geometry_sm}" height="{$item->getImageUrl()|img_height:$geometry_sm}">
					<source srcset="{$item->getImageUrl()|img_url:$geometry_sm}" width="{$item->getImageUrl()|img_width:$geometry_sm}" height="{$item->getImageUrl()|img_height:$geometry_sm}">
				{/if}
				<img src="{$item->getImageUrl()|img_url:$geometry_lg}" class="img-fluid" alt="{$item->getTitle()}" width="{$item->getImageUrl()|img_width:$geometry_lg}" height="{$item->getImageUrl()|img_height:$geometry_lg}">
			</picture>
		{if $item->getUrl()}
			</a>
		{/if}
	{/if}{*<div><p>{$item->getImageUrl()}</p>***<p>{$item->getSmallImageUrl()}</p></div>*}
</div>
