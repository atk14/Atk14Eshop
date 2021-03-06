{if $branches}

<ul class="list--tree">
{foreach $branches as $branch}

		<li>
			{if $branch.system_parameter}
				{assign type $branch.system_parameter->getType()->getCode()}
				{assign content $branch.system_parameter->getContent(["consider_returning_parent_content" => false])}

				<div class="row">
					<div class="col-3">
						{if $branch.system_parameter->isMandatory()}<strong>{/if}
						{a action="edit" id=$branch.system_parameter}{$branch.key}{/a}
						{if $branch.system_parameter->isMandatory()}</strong>{/if}
					</div>
					<div class="col-9">
						{$branch.system_parameter->getName()}:
						{if $type=="image_url"}
							{!$content|pupiq_img:"80x80"|default:$mdash}
						{elseif $type=="boolean"}
							{if is_null($content)}
								{$mdash}
							{else}
								<em>{!$content|display_bool}</em>
							{/if}
						{else}
							<em>{$content|truncate|default:$mdash}</em>
						{/if}
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
