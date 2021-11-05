{a action=detail id=$article _class="card"}
	{if $article->getImageUrl()}
		<img {!$article->getImageUrl()|img_attrs:"400x300xcrop"} class="card-img-top" alt="{$article->getTitle()}">
	{else}
		<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" alt="" title="{t}no image{/t}" class="card-img-top">
	{/if}
	<div class="card-body">
		<h2 class="card-title">{$article->getTitle()}</h2>
		{if $article->getTeaser()}
		<div class="card-teaser">{$article->getTeaser()|markdown|strip_html|truncate:200}</div>
		{/if}
	</div>
	<div class="card-footer">
		<p class="card-meta">{render partial="author_and_date"}</p>
	</div>
{/a}
