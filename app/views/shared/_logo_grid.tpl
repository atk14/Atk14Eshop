{*
	* Show link list as logo grid with proportional logo sizes
	* {render partial="shared/logo_grid" link_list=$logo_grid_items show_titles=false fixed_size=false}
	*
	* show_titles=false when true, link titles are shown
	* fixed_size=false when true, items have fixed size
*}

<section class="section--logo-grid">
	{if $link_list->getTitle()}
		{render partial="shared/layout/content_header" title=$link_list->getTitle() title_tag="h2" tags=false image="" teaser=""}
	{/if}
	{assign "geometry" "400x400"}
	{assign "basePadding" 20}
	<div class="logo-grid{if $fixed_size} logo-grid--fixed-size{/if}">
		{foreach $link_list->getItems($current_region) as $item}
		<a href="{$item->getUrl()}" title="{$item->getTitle()}" class="logo-grid__item col-4 col-sm-3 col-lg-2">
			{if $item->getImageUrl()}
				{assign "img_w" $item->getImageUrl()|img_width:$geometry}
				{assign "img_h" $item->getImageUrl()|img_height:$geometry}
				{assign "img_ratio" $img_w/$img_h}
				<span class="logo-grid__image">
					<span class="logo-grid__logo-wrap {if $img_ratio < 1}logo--vertical{else}logo--horizontal{/if}" style="padding: {$basePadding|calculate_logogrid_padding:$img_ratio}%;">
							<img src="{$item->getImageUrl()|img_url:$geometry}" alt="{$item->getTitle()}" width="{$img_w}" height="{$img_h}">
					</span>
				</span>
				{*<code class="logo-grid__debug">
					<div>ir: {$img_ratio}</div>
					<div>pa: {$basePadding|calculate_logogrid_padding:$img_ratio}</div>
				</code>*}
			{/if}
			{if $show_titles}
			<span class="logo-grid__text">
				{$item->getTitle()}
			</span>
			{/if}
		</a>
		{/foreach}
	</div>
</section>