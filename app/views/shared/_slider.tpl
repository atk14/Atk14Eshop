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
	{if $slider->getVisibleItems()|count > 1}
		<div class="swiper-container" data-slides_per_view="{$slides_per_view|default: 1}" data-loop="{$loop|default: true}" data-autoplay="{$autoplay|default:6000}" data-slider_id="{$uniqid}" id="swiper_{$uniqid}">
			<div class="swiper-wrapper">

				{foreach $slider->getVisibleItems() as $item}
					{render partial="shared/slider_slide" slide_number=$item@iteration-1}
				{/foreach}

			</div>

			<!-- If we need navigation buttons -->
			<div class="swiper-button-prev" id="swiper_button_prev_{$uniqid}"><span class="sr-only">{t}Previous{/t}</span></div>
			<div class="swiper-button-next" id="swiper_button_next_{$uniqid}"><span class="sr-only">{t}Next{/t}</span></div>
			<div class="container-fluid--fullwidth swiper-pagination" id="swiper_pagination_{$uniqid}"></div>
		</div>
		{*<div class="swiper-pagination" id="swiper_pagination_{$uniqid}"></div>*}
	{else}
		{* when there is just one slide, render it without Swiper wrappers and navigation etc. *}
		{foreach $slider->getVisibleItems() as $item}
			{render partial="shared/slider_slide"}
		{/foreach}
	{/if}
</section>
{/if}
