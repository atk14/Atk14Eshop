{if sizeof($allowed_regions)>1}

{assign uniqid ""|uniqid}

<li class="nav-item dropdown regionswitch">
	<a href="#" class="nav-link dropdown-toggle" role="button" id="regionswitch_{$uniqid}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{t}Select selling region{/t}">
		{$current_region->getName()}
		<span class="caret"></span>
	</a>
	<div class="dropdown-menu {$dropdown_class}" aria-labelledby="regionswitch_{$uniqid}">
		{foreach $allowed_regions as $region}
			{if $region->getId()!==$current_region->getId()}
				{a namespace="" action="regions/set_region" id=$region _class="dropdown-item" _method="post" _rel="nofollow"}
					{$region->getName()}
				{/a}
			{/if}	
		{/foreach}
	</div>
</li>

{/if}
