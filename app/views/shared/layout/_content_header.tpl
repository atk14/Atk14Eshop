{*
	Renders page H1 heading with optional teaser and small image
	{render partial="shared/layout/content_header" title=$page->getTitle()}
	{render partial="shared/layout/content_header" title=$page->getTitle() teaser=$page->getTeaser()|markdown image=$image brand=$brand title_tag="h1" tags=$tags meta=$meta colorbg=true}

	title: page title
	teaser: page teaser
	meta: typically author of the post, publish date...
	author
	image: header image
	colorbg: if true texts will have background color (auto-picked dark vibrant color from image)
	brand: content displayed just above teaser
	title_tag: heading html tag used (default "h1")
	tags: array of tags
*}
{if !$title_tag}
	{assign var=title_tag "h1"}
{/if}
<header class="content-header">
	{if $image}
		{assign var="geometry_detail" "800x"}
		{assign var="aspect_ratio"  $image|img_width:$geometry_detail/$image|img_height:$geometry_detail}
		<div class="content-header__image{if $aspect_ratio<1} content-header__image--portrait{/if}" style="background-color: {$image|img_color:"dark_vibrant"|default:"#333333"}">
			<img src="{$image|img_url:$geometry_detail}" class="img-fluid" style="background-color: {$image|img_color:"light_vibrant"|default:{$image|img_color:"light_muted"}|default:"#333333"}" alt="{$title}">
		</div>
	{/if}
	<div class="content-header__text{if $colorbg} content-header__text--dark{/if}"{if $image && $colorbg} style="background-color: {$image|img_color:"dark_vibrant"|default:{$image|img_color:"dark_muted"}|default:"#333333"}"{/if}>
		{if $tags}
			<div class="tags">{render partial="shared/tags" tags=$tags}</div>
		{/if}
		<{$title_tag} class="h1">{vlnka}{!$title}{/vlnka}</{$title_tag}>
		{if $author|trim}
		<div class="author">{!$author}</div>
		{/if}
		{if $teaser|trim || $brand|trim  || $meta|trim }
		<div class="teaser">
			{if $brand|trim}
				{!$brand}<br>
			{/if}
			{vlnka}{!$teaser}{/vlnka}
			{if $meta|trim}
				<p class="meta">{!$meta}</p>
			{/if}
		</div>
		{/if}
	</div>
</header>
