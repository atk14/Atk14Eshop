{*
	Renders page H1 heading with optional teaser and small image
	{render partial="shared/layout/content_header" title=$page->getTitle()}
	{render partial="shared/layout/content_header" title=$page->getTitle() teaser=$page->getTeaser()|markdown image=$image brand=$brand tag="h1" tags=$tags meta=$meta colorbg=true}

	title: page title
	teaser: page teaser
	meta: typically author name, publish date
	image: header image
	colorbg: if true texts will have background color (auto-picked dark vibrant color from image)
	brand: content displayed just above teaser
	tag: heading html tag used (default "h1")
	tags: array of tags
*}
{if !$tag}
	{assign var=tag "h1"}
{/if}
<header class="content-header">
	{if $image}
		<div class="content-header__image" style="background-color: {$image|img_color:"dark_vibrant"|default:"#333333"}">
			<img src="{$image}" class="img-fluid" style="background-color: {$image|img_color:"light_vibrant"|default:"#333333"}">
		</div>
	{/if}
	<div class="content-header__text{if $colorbg} content-header__text--dark{/if}"{if $image && $colorbg}style="background-color: {$image|img_color:"dark_vibrant"|default:"#333333"}"{/if}>
		{if $tags}
			<div class="tags">{render partial="shared/tags" tags=$tags}</div>
		{/if}
		<{$tag} class="h1">{!$title}</{$tag}>
		{if $teaser || $brand  || $meta }
		<div class="teaser">
			{if $brand}
				{!$brand}<br>
			{/if}
			{!$teaser}
			{if $meta}
				<p class="meta">{!$meta}</p>
			{/if}
		</div>
		{/if}
	</div>
</header>