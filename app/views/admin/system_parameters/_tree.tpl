<ul class="list-unstyled">
{foreach $tree as $branch}

		<li>
			{if $branch.system_parameter}
				<h3>{a action="edit" id=$branch.system_parameter}{$branch.key}{/a}</h3>
			{else}
				<h3>{$branch.key}</h3>
			{/if}
			{render partial="tree_branch" branches=$branch.children}
		</li>

{/foreach}
</ul>
