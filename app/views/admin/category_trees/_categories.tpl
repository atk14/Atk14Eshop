{if $categories}
	<ul class="list--tree list--tree-collapsible{if $tree_id} collapse{/if}"{if $tree_id} id="{$tree_id}"{/if}>
		{foreach $categories as $c}
			<li>
				{if $c->getChildCategories()}
					{assign var="child_tree_id" value="tree_"|cat:uniqid()}
					<span class="js-collapse-toggle" data-toggle="collapse" data-target="#{$child_tree_id}"><span class="js-icon--collapsed">{!"plus"|icon}</span><span class="js-icon--expanded">{!"minus"|icon}</span></span>
				{/if}
				{if $c->isFilter()}<em>{!"filter"|icon} {t}filter{/t}:</em>{/if}
				{if $c->isPointingToCategory()}<em>{!"share-alt"|icon} {t}link{/t}:</em>{/if}
				
				{if !$c->isPointingToCategory() and !$c->isFilter()}<em>{!"folder-open"|icon}</em>{/if}

				{a action="categories/edit" id=$c}{$c->getName()}{/a}

				{if !$c->g("visible")} <em>{!"eye-slash"|icon} ({t}invisible{/t})</em>{/if}

				{render partial=categories categories=$c->getChildCategories() tree_id=$child_tree_id}
			</li>
		{/foreach}
	</ul>
{/if}
