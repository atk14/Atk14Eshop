{assign roles CardCreator::GetCreatorRolesForCard($card)}

{if $roles}
	{foreach $roles as $role}
		{assign creators CardCreator::GetCreatorsForCard($card,$role)}
		<section class="section--product-info section--creators">
			<h3 class="section__title">
				{if sizeof($creators)>1}
					{$role->getPluralName()}
				{else}
					{$role->getName()}
				{/if}
			</h3>
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
