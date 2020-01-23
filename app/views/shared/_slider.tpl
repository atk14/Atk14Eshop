{*

{render partial="shared/slider" slider=$slider}
{render partial="shared/slider" slider=$slider loop=true autoplay=6000 slides_per_view=1}

$loop=true|false  									default: true
$autoplay=true|false|milliseconds		 default: 6000
$slides_per_view=auto|number 				default: 1

*}

{if $slider}
{assign uniqid uniqid()}
<section class="section--slider">
	
	<div class="swiper-container" data-slides_per_view="{$slides_per_view|default: 1}" data-loop="{$loop|default: true}" data-autoplay="{$autoplay|default:6000}" data-slider_id="{$uniqid}" id="swiper_{$uniqid}">
		<div class="swiper-wrapper">

			{foreach $slider->getItems() as $item}
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
			{/foreach}

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev" id="swiper_button_prev_{$uniqid}"><span class="sr-only">{t}Previous{/t}</span></div>
		<div class="swiper-button-next" id="swiper_button_next_{$uniqid}"><span class="sr-only">{t}Next{/t}</span></div>
		<div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_{$uniqid}"></div>
	</div>
	{*<div class="swiper-pagination" id="swiper_pagination_{$uniqid}"></div>*}
</section>
{/if}
