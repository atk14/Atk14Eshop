{assign roles CardCreator::GetCreatorRolesForCard($card)}
{*
	Two layout variations

	$authors_complex_layout 1:
	--------------------------------
	Creators  Author      John Doe
	          ----------------------
	          Illustrator John Doe
	--------------------------------
	
	$authors_complex_layout 0:
	--------------------------------
	Author        John Doe
	--------------------------------
	Illustrator   John Doe
	--------------------------------
*}
{assign authors_complex_layout 0}
{if $roles}
	{if $roles|count > 1 && $authors_complex_layout == true}
		<section class="section--product-info section--creators">
			<h2 class="section__title">{t}Creators{/t}</h2>
			<div class="section__body">
				<table class="table table-sm">
					{foreach $roles as $role}
						{assign creators CardCreator::GetCreatorsForCard($card,$role)}
						<tr>
							<th>
								{if sizeof($creators)>1}
									{$role->getPluralName()}
								{else}
									{$role->getName()}
								{/if}
							</th>
							<td>
								{foreach $creators as $creator}
									{assign page $creator->getPage()}
									{trim}
									{if $page}<a href="{$page|link_to_page}">{/if}{$creator}{if $page}</a>{/if}
									{/trim}{if !$creator@last}, {/if}
								{/foreach}
							</td>
						</tr>
					{/foreach}	
				</table>
			</div>
		</section>
	{else}
		{foreach $roles as $role}
			{assign creators CardCreator::GetCreatorsForCard($card,$role)}
			<section class="section--product-info section--creators">
				<h2 class="section__title">
					{if sizeof($creators)>1}
						{$role->getPluralName()}
					{else}
						{$role->getName()}
					{/if}
				</h2>
				<div class="section__body">
					{foreach $creators as $creator}
						{assign page $creator->getPage()}
						{trim}
						{if $page}<a href="{$page|link_to_page}">{/if}{$creator}{if $page}</a>{/if}
						{/trim}{if !$creator@last}, {/if}
					{/foreach}
				</div>
			</section>
		{/foreach}
	{/if}
{/if}
