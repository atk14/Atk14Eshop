{assign active_filters $filter->getActiveFilters($page_params)}

{strip}
<div class="active-filters js--active_filters">
	{if $active_filters}
	<h6 class="active-filters__title">{t}Vybráno:{/t}</h6>
	<div class="active-filters__items">
		<ul class="list list--active-filters">
			{foreach $active_filters as $active}
			<li class="list__item">
				{a_params _class='js--active-filter chip' _remote=1 _params=$active['params'] _title="{t}odstranit toto omezení výběru{/t}" _rel="nofollow"}{$active['label']} <strong>&times;</strong>{/a_params}
			</li>
			{/foreach}
			{if count($active_filters)>=3}
			<a href="{$category_base_uri}" class="remote-link js--active-filter" data-remote="true" rel="nofollow">{t}Odstranit všechny filtry{/t}</a>
			{/if}
		</ul>
	</div>
	{/if}
	<div class="active-filters__count">
		<div class="catproductcount js--products-count">
			{render partial="shared/paging_count"}
		</div>
	</div>
</div>
{/strip}
