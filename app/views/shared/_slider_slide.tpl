<div class="swiper-slide slider-item-{$slide_number}">
	{if $item->getTitle() != "" || $item->getDescription() != ""}
		<div class="swiper-slide__image">
			<img src="{$item->getImageUrl()|img_url:"900x600xcrop"}" class="img-fluid" alt="{$item->getTitle()}">
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
			<img src="{$item->getImageUrl()|img_url:"1500x500xcrop"}" class="d-none d-md-block img-fluid" alt="{$item->getTitle()}">
			<img src="{$item->getImageUrl()|img_url:"900x300xcrop"}" class="d-block d-md-none img-fluid" alt="{$item->getTitle()}">
		{if $item->getUrl()}
			</a>
		{/if}
	{/if}
</div>
