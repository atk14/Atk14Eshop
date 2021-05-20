<div class="card card--search card--search--searchablewidget">
	<div class="card__image">
		<a href="{$searchable_widget->getUrl()}"><img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top"></a>

		<div class="card__label"></div>
	</div>
	<div class="card-body">
		<h4 class="card-title">
			<a href="{$searchable_widget->getUrl()}">{highlight_keywords keywords=$params.q tag="<mark>"}{$searchable_widget->getTitle()}{/highlight_keywords}</a>
		</h4>
		<div class="card-text"><p>{highlight_keywords keywords=$params.q tag="<mark>"}{!$searchable_widget->getBody()|markdown}{/highlight_keywords}</p></div>
	</div>
	
	<div class="card-footer">
		<a href="{$searchable_widget->getUrl()}" class="btn btn-primary btn-sm">{$searchable_widget->getUrlTitle()}</a>
	</div>
	
</div>
