{if $creators}
<section class="section--product-info section--creators">
		<div class="section__body">
			<ul>
			{foreach $creators as $creator}
				{assign page $creator->getPage()}
				<li>
					{$creator->getRole()}:
					{if $page}<a href="{$page|link_to_page}">{/if}
					{$creator}
					{if $page}</a>{/if}
				</li>
			{/foreach}
			</ul>
		</div>
</section>
{/if}
