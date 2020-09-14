<li class="search-results-item">
	<div class="search-results-item--image">
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				<a href="{$searchable_widget->getUrl()}">{$searchable_widget->getTitle()}</a>
			</h4>
			<p class="search-result-description">{!$searchable_widget->getBody()|markdown}</p>
		</div>
		<div class="search-results-item--actions">
			<a href="{$searchable_widget->getUrl()}" class="btn btn-primary btn-sm">{$searchable_widget->getUrlTitle()}</a>
		</div>
	</div>
	<div class="search-results-item--tag">
	</div>
</li>
