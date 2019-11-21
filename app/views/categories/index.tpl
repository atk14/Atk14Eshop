{render partial="shared/layout/content_header" title=$page_title}

<div class="card-deck card-deck--sized-4">
	{foreach $categories as $category}
	{a action="detail" path=$category->getSlug() _class="card"}
		{!$category->getImageUrl()|pupiq_img:"!400x300,enable_enlargement":"class='card-img-top'"}
		<div class="card-body">
			<h4 class="card-title">{$category->getName()}</h4>
			<div class="card-text">{$category->getTeaser()}</div>
		</div>
	{/a}
	{/foreach}
</div>
