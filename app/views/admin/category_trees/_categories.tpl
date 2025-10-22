{if $categories && sizeof($categories)>0}
	<ul class="list--tree list--tree-collapsible{if $tree_id} collapse{/if}"{if $tree_id} id="{$tree_id}"{/if}>
		{foreach $categories as $node}
			{assign var=c value=$node->getCategory()}
			<li>
				{assign var="child_tree_id" value=null}
				{if $node->getChildCategories()}
					{assign var="child_tree_id" value="tree_"|cat:uniqid()}
					<span class="js-collapse-toggle" data-bs-toggle="collapse" data-bs-target="#{$child_tree_id}"><span class="js-icon--collapsed">{!"plus"|icon}</span><span class="js-icon--expanded">{!"minus"|icon}</span></span>
				{/if}
				{if $c->isFilter()}<em>{!"filter"|icon} {t}filter{/t}:</em>{/if}
				{if $c->isPointingToCategory()}<em>{!"share-alt"|icon} {t}link{/t}:</em>{/if}
				
				{if !$c->isPointingToCategory() and !$c->isFilter()}<em>{!"folder-open"|icon}</em>{/if}

				{a action="categories/edit" id=$c}{$c->getName()}{/a}

				{if !$c->g("visible")} <em>{!"eye-slash"|icon} ({t}invisible{/t})</em>{/if}

				{* For a large tree, the include si far more quick than "render partial". *}
				{* render partial=categories categories=$node tree_id=$child_tree_id *}
				{include file="_categories.tpl" categories=$node tree_id=$child_tree_id}
			</li>
		{/foreach}
	</ul>
{/if}
