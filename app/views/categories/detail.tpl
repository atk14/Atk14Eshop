{admin_menu for=$category}
{if $category->getTeaser()}
	{assign teaser $category->getTeaser()|markdown}
{/if}
{capture assign=title}
	{$category->getLongName()} {* <small>({$finder->getRecordsCount()})</small> *}
{/capture}
{assign image $category->getImageUrl()|img_url:"600x600"}
{if !$teaser|trim|strlen}
	{* no teaser? -> do not display the image *}
	{assign image ""}
{/if}
{render partial="shared/layout/content_header" title=$title teaser=$teaser image=$image}

<section class="border-top-0">
	{!$category->getDescription()|markdown}
</section>

{if $child_categories && $child_categories|@count>0}
	{render partial="child_categories"}
{/if}

{render partial='shared/filter/filter_form' form=$form}

<section class="section--list-products" id="cards">
	{*<h4>{t}Products{/t}</h4>*}
	{if $finder->isEmpty()}
		<p>{t}No product has been found.{/t}</p>
	{else}
		{render partial='shared/ajax_pager/ajax_pager'}
	{/if}
</section>

