<article class="media">
	<img {!$article->getImageUrl()|img_attrs:"64x64xcrop"} class="mr-3">
	<div class="media-body">
	<h2>{a action=detail id=$article}{$article->getTitle()}{/a}</h2>
	<p>
		{$article->getTeaser()}
	</p>
	<p>{render partial="author_and_date"}</p>
	</div>
</article>
