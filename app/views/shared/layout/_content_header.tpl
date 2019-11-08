{*
	Renders page H1 heading with optional teaser and small image
	{render partial="shared/layout/content_header" title=$page->getTitle()}
	{render partial="shared/layout/content_header" title=$page->getTitle() teaser=$page->getTeaser()|markdown image=$image brand=$brand tag="h2"}
*}
{if !$tag}
	{assign var=tag "h1"}
{/if}
<header class="content-header">
	{if $image}
		<img src="{$image}" class="img-fluid content-header__image">
	{/if}
	<{$tag} class="h1">{!$title}</{$tag}>
	{if $teaser || $brand }
	<div class="teaser">
		{if $brand}
			{!$brand}<br>
		{/if}
		{!$teaser}
	</div>
	{/if}
	{if $image}<div class="clearfix"></div>{/if}
</header>