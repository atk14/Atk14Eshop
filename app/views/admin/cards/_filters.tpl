{capture assign=return_uri}{$request->getRequestUri()}#filters{/capture}

<h3 id="filters">{button_create_new action="card_filters/edit" id=$card return_uri=$return_uri}{t}Set up filters{/t}{/button_create_new} {t}Filters{/t}</h3>
{if $filters}

	<ul>
		{foreach $filters as $f}
			<li>/{$f.filter->getPath()}/:
				{foreach $f.items as $c}
					{$c->getName()}{if !$c@last}, {/if}
				{/foreach}
			</li>
		{/foreach}
	</ul>

{else}

	<p>{t}This product is not included in any filter{/t}</p>

{/if}
