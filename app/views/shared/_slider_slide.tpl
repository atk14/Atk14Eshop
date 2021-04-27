{assign var=geometry_lg value="1500x500xcrop"}
{assign var=geometry_sm value="900x300xcrop"}
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
			<img src="{$item->getImageUrl()|img_url:$geometry_sm}" class="d-block d-md-none img-fluid" alt="{$item->getTitle()}" width="{$item->getImageUrl()|img_width:$geometry_sm}" height="{$item->getImageUrl()|img_height:$geometry_sm}">
		{if $item->getUrl()}
			</a>
		{/if}
	{/if}
</div>
