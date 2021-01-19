<div class="swiper-slide slider-item-{$item@iteration-1}">
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
</div>