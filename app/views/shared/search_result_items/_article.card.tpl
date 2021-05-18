<div class="card card--search card--search--article">
	<div class="card__image">
		{a action="articles/detail" id=$article}
			{if $article->getImageUrl()}
					<img {!$article->getImageUrl()|img_attrs:'400x300x#ffffff'} alt="{$article->getTitle()}" class="card-img-top">
			{else}
				<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top">
			{/if}
		{/a}


		<div class="card__label">
			{if $article->getPrimaryTag()}
				{$article->getPrimaryTag()->getTagLocalized()|capitalize}
			{else}
				{t}Article{/t}
			{/if}
		</div>
	</div>
	<div class="card-body">
		<h4 class="card-title">{a action="articles/detail" id=$article}{$article->getTitle()}{/a}</h4>
		<div class="card-text">{$article->getTeaser()}</div>
		<p class="card-meta">{t date=$article->getPublishedAt()|format_date escape=no}Zveřejněno dne %1{/t}</p>
	</div>
	
	<div class="card-footer">
		{a action="articles/detail" id=$article _class="btn btn-primary btn-sm"}{t}Celý článek{/t}{/a}
	</div>
	
</div>
