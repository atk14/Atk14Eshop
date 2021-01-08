{if $creators}
<section class="section--product-info section--creators">
		<div class="section__body">
			<table class="table table-sm">
				{foreach $creators as $creator}
					{assign page $creator->getPage()}
					<tr>
						<th>{$creator->getRole()}</th>
						<td>
							{if $page}<a href="{$page|link_to_page}">{/if}
							{$creator}
							{if $page}</a>{/if}
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
</section>
{/if}
