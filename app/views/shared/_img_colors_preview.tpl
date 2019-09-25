{*
	Renders preview of colors palette generated from image.
	Intended for developer use.
	Usage: {render partial="shared/img_colors_preview" image=$article->getImageUrl()}
*}
{$color_names = ["vibrant", "light_vibrant", "dark_vibrant", "muted", "light_muted", "dark_muted"]}

<div class="img_colors_preview">
	{foreach from=$color_names item=$colname}
		{assign var="color" value=$article->getImageUrl()|img_color:$colname}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:"#333333"}">
			<span>{$colname}: {$color|default:"--"}</span>
		</div>
	{/foreach}
</div>