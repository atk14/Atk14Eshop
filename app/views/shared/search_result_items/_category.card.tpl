{assign parent_category $category->getParentCategory()}

<div class="card card--search card--search--category">
<div class="card__image">
		{a action="categories/detail" path=$category->getPath()}
			{if $category->getImageUrl()}
				<img {!$category->getImageUrl()|img_attrs:'400x300x#ffffff'} alt="{$category->getName()}" class="card-img-top">
			{else}
				<img src="{$public}dist/images/default_category_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top">
			{/if}
		{/a}

		<div class="card__label">
			{t}Kategorie{/t}
		</div>
	</div>
	<div class="card-body">
		<h4 class="card-title">
			{highlight_keywords keywords=$params.q tag="<mark>"}
				{if $parent_category && $parent_category->getCode()!=="catalog"}
					<a href="{$parent_category|link_to_category}">{$parent_category->getLongName()}</a> /
				{/if}
				<a href="{$category|link_to_category}">{$category->getLongName()}</a>
			{/highlight_keywords}
		</h4>
		<div class="card-text">
			{highlight_keywords keywords=$params.q tag="<mark>"}
				{remove_if_contains_no_text}<p>{$category->getTeaser()|markdown|strip_html|truncate:300}</p>{/remove_if_contains_no_text}

				{* few child categories *}
				{assign limit 4}
				{assign child_cats  $category->getChildCategories(["direct_children_only" => true, "is_filter" => false, "visible" => true, "visible_to_user" => $logged_user, "limit" => $limit+1])}
				{if $child_cats}
					{assign limit_exceeded sizeof($child_cats)>$limit}
					<ul class="list-unstyled">
						{foreach $child_cats as $child_cat}
							<li>
							{if $limit_exceeded && $child_cat@last}
								<span class="text-muted">{t}a další...{/t}</span>
							{else}
								<a href="{$child_cat|link_to_category}">{$child_cat}</a>
							{/if}
							</li>
						{/foreach}
					</ul>
				{/if}

			{/highlight_keywords}
		</div>
	</div>

	<div class="card-footer">
		{a action="categories/detail" path=$category->getPath() _class="btn btn-primary btn-sm"}{t}Zobrazit kategorii{/t}{/a}
	</div>
</div>
