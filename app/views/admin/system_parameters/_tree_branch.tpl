{if $branches}

<ul class="list--tree">
{foreach $branches as $branch}

		<li>
			{if $branch.system_parameter}
				<div class="row">
				<div class="col-3">
					{if $branch.system_parameter->isMandatory()}<strong>{/if}
					{a action="edit" id=$branch.system_parameter}{$branch.key}{/a}
					{if $branch.system_parameter->isMandatory()}</strong>{/if}
				</div>
				<div class="col-9">
					{$branch.system_parameter->getName()}: <em>{$branch.system_parameter->getContent()|truncate|default:$mdash}</em>
				</div>
				</div>
			{else}
				{$branch.key}
			{/if}
			{render partial="tree_branch" branches=$branch.children}
		</li>

{/foreach}
</ul>

{/if}
