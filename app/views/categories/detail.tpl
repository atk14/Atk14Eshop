{admin_menu for=$category}
{if $category->getTeaser()}
	{assign teaser $category->getTeaser()|markdown}
{/if}
{capture assign=title}
	{$category->getName()} <small>({$cards_finder->getRecordsCount()})</small>
{/capture}
{render partial="shared/layout/content_header" title=$title teaser=$teaser image=$category->getImageUrl()|img_url:"200x200" }


<section class="border-top-0">
	{!$category->getDescription()|markdown}
</section>

{if $child_categories}
	<section class="section--child-categories">
		<ul class="list-unstyled list--categories list--categories--columns">
			{foreach $child_categories as $cc}
			<li class="list-item">
				{a path=$cc.path}
					{if $cc.category->getImage()}
						{!$cc.category->getImage()|pupiq_img:"!60x60":"class='child-category__image'"}
					{/if}
				<div class="child-category__text">
					<h4 class="child-category__text__title">{$cc.name} <small>({$cc.cards_count})</small> {!"angle-right"|icon}</h4>
					{if $cc.category->getTeaser()}
						<p class="child-category__text__teaser">{$cc.category->getTeaser()}</p>
					{/if}
				</div>
				{/a}
			</li>
			{/foreach}
		</ul>
	</section>
{/if}


<section class="section--list-products">
	{*<h4>{t}Products{/t}</h4>*}
	{if $cards_finder->isEmpty()}
		<p>{t}No product has been found.{/t}</p>
	{else}
		<div class="card-deck card-deck--sized-4 product-list" data-record_count="{$cards_finder->getRecordsCount()}">

			{foreach $cards_finder->getRecords() as $card}
				{render partial="shared/card_item" card=$card}
			{/foreach}
			
		</div>
		{paginator finder=$cards_finder items_total_label="{t}products in total{/t}"}
	{/if}
</section>

{if $canonical_path}
	{content for=head}
		<link rel="canonical" href="{link_to action=detail path=$canonical_path}" />
	{/content}
{/if}
