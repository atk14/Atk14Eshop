<a class="pager__item" href="{link_to action=detail id=$pager_article}"{if $pager_article->getImageUrl()} style="background-color: {$pager_article->getImageUrl()|img_color:"dark_muted"|default:"#333333"};"{/if}>
	<div class="pager__item__text">
		<p class="pager__item__title">{$pager_article->getTitle()|truncate:60}</p>
	</div>
	<div class="pager__item__image"{if $pager_article->getImageUrl()} style="background-image: url({!$pager_article->getImageUrl()|img_url:"300x300xcrop"});"{/if}></div>
</a>