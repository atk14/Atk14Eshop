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
<div class="img_colors_preview">
		{assign var="color" value=$article->getImageUrl()|img_color:"vibrant"}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:{$article->getImageUrl()|img_color:"muted"}|default:"#333333"}">
			<span>vibrant: {$color|default:"--"}</span>
		</div>
		{assign var="color" value=$article->getImageUrl()|img_color:"light_vibrant"}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:{$article->getImageUrl()|img_color:"light_muted"}|default:"#333333"}">
			<span>light_vibrant: {$color|default:"--"}</span>
		</div>
		{assign var="color" value=$article->getImageUrl()|img_color:"dark_vibrant"}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:{$article->getImageUrl()|img_color:"dark_muted"}|default:"#333333"}">
			<span>dark_vibrant: {$color|default:"--"}</span>
		</div>
		{assign var="color" value=$article->getImageUrl()|img_color:"muted"}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:{$article->getImageUrl()|img_color:"vibrant"}|default:"#333333"}">
			<span>muted: {$color|default:"--"}</span>
		</div>
		{assign var="color" value=$article->getImageUrl()|img_color:"light_muted"}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:{$article->getImageUrl()|img_color:"light_vibrant"}|default:"#333333"}">
			<span>light_muted: {$color|default:"--"}</span>
		</div>
		{assign var="color" value=$article->getImageUrl()|img_color:"dark_muted"}
		<div class="img_colors_preview__sample{if !$color} color_undefined{/if}" style="background-color: {$color|default:{$article->getImageUrl()|img_color:"dark_vibrant"}|default:"#333333"}">
			<span>dark_muted: {$color|default:"--"}</span>
		</div>
</div>