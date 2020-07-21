{*

{render partial="shared/slider" slider=$slider}
{render partial="shared/slider" slider=$slider loop=true autoplay=6000 slides_per_view=1}

$loop=true|false  									default: true
$autoplay=true|false|milliseconds		 default: 6000
$slides_per_view=auto|number 				default: 1
$breakpoint=number									default: undefined - applies only if slides_per_view is "auto"
$centered_slides=true|false					default: undefined
*}

{if $slider}
{assign uniqid uniqid()}
<section class="section--slider">
	
	<div class="swiper-container swiper--images" data-slides_per_view="{$slides_per_view|default: 1}" data-loop="{$loop|default: true}" data-autoplay="{$autoplay|default:6000}" data-slider_id="{$uniqid}" id="swiper_{$uniqid}"{if $breakpoint} data-breakpoint="{$breakpoint}"{/if}{if $centered_slides} data-centered_slides="{$centered_slides}"{/if}>
		<div class="swiper-wrapper">

			{foreach $slider->getVisibleItems() as $item}
				<div class="swiper-slide slider-item-{$item@iteration-1}" style="width: auto">
					{if $item->getUrl()}
						<a href="{$item->getUrl()}" title="{$item->getTitle()}">
					{/if}
					<img src="{$item->getImageUrl()|img_url:"1000x600"}" class="img-fluid" alt="{$item->getTitle()}">
					{if $item->getUrl()}
						</a>
					{/if}
					{*<div class="position-absolute d-block bg-primary text-light p-1">slide {$item@iteration-1}</div>*}
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
