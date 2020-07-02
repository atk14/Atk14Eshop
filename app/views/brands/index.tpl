{render partial="shared/layout/content_header" title=$page_title}

<div class="card-deck card-deck--sized-4">
{foreach $brands as $brand}
	
	{a action="detail" id=$brand _class="card"}
		{!$brand->getLogoUrl()|pupiq_img:"400x400x#ffffff,format=png":"class='card-img-top'"}
		<div class="card-body">
			<h4 class="card-title">{$brand->getName()}</h4>
			<div class="card-text">{$brand->getTeaser()}</div>
		</div>
	{/a}
	
{/foreach}
</div>
