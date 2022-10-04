{assign roles CardCreator::GetCreatorRolesForCard($card)}

{if $roles}
<section class="section--product-info section--creators">
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
{/if}
