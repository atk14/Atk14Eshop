<h1>{$page_title}</h1>

<ul class="list--categories">
	<li>
		<h3>{a action="categories/edit" id=$root}{!"folder-open"|icon} {$root->getName()}{/a}{if !$root->g("visible")} <small><em>({!"eye-slash"|icon} {t}invisible{/t})</em></small>{/if}  <button class="btn btn-sm btn-outline-secondary js-toggle-all-trees collapsed"><span class="btn__text--collapsed">{t}Expand all{/t}</span><span class="btn__text--expanded">{t}Collapse all{/t}</span></button></h3>
		{render partial=categories categories=$root->getChildCategories()}
	</li>
</ul>
