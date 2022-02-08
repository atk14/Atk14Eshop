{assign var=geometry_lg value="1500x500xcrop"}
{assign var=geometry_sm value="900x300xcrop"}
{assign var=geometry_sm_fullheight value="900x900xcrop"}{* h =  1 * w *}
{assign var=geometry_xs_fullheight value="900x1035xcrop"}{* h = 1.15 * w *}
{assign var=geometry_half value="900x600xcrop"}
<div class="swiper-slide slider-item-{$slide_number}">
	{if $item->getTitle() != "" || $item->getDescription() != ""}
		<div class="swiper-slide__image">
			<img src="{$item->getImageUrl()|img_url:$geometry_half}" class="img-fluid" alt="{$item->getTitle()}" width="{$item->getImageUrl()|img_width:$geometry_half}" height="{$item->getImageUrl()|img_height:$geometry_half}">
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
		{if $item->getUrl()}
			<a href="{$item->getUrl()}">
		{/if}
			<img src="{$item->getImageUrl()|img_url:$geometry_lg}" class="d-none d-md-block img-fluid" alt="{$item->getTitle()}" width="{$item->getImageUrl()|img_width:$geometry_lg}" height="{$item->getImageUrl()|img_height:$geometry_lg}">
			{if $item->getSmallImageUrl()}
				<img src="{$item->getSmallImageUrl()|img_url:$geometry_sm_fullheight}" class="d-none d-sm-block d-md-none img-fluid" alt="{$item->getTitle()}" width="{$item->getSmallImageUrl()|img_width:$geometry_sm_fullheight}" height="{$item->getSmallImageUrl()|img_height:$geometry_sm_fullheight}">
				<img src="{$item->getSmallImageUrl()|img_url:$geometry_xs_fullheight}" class="d-block d-sm-none img-fluid" alt="{$item->getTitle()}" width="{$item->getSmallImageUrl()|img_width:$geometry_xs_fullheight}" height="{$item->getSmallImageUrl()|img_height:$geometry_xs_fullheight}">
			{else}
				<img src="{$item->getImageUrl()|img_url:$geometry_sm}" class="d-block d-md-none img-fluid" alt="{$item->getTitle()}" width="{$item->getImageUrl()|img_width:$geometry_sm}" height="{$item->getImageUrl()|img_height:$geometry_sm}">
			{/if}
		{if $item->getUrl()}
			</a>
		{/if}
	{/if}{*<div><p>{$item->getImageUrl()}</p>***<p>{$item->getSmallImageUrl()}</p></div>*}
</div>
