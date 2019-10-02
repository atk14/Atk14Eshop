{admin_menu for=$page}
<article>
	<header class="content-header">
		<h1>{$page->getTitle()}</h1>
		<div class="teaser">
		{!$page->getTeaser()|markdown}
		</div>
	</header>
	
	<section class="page-body">
		{if !$page->isVisible()}
			<p><em>{t}This is not a visible page! It's not available to the public audience.{/t}</em></p>
		{/if}
		{!$page->getBody()|markdown}
	</section>
	
</article>

{if $page->getCode()=="contact"}
	{render_component controller="contact_messages" action="create_new"}
{/if}

{if $child_pages}
	<section class="child-pages">
		<h4>{t}Subpages{/t}</h4>
		<ul>
		{foreach $child_pages as $child_page}
			<li>{a action=detail id=$child_page}{$child_page->getTitle()}{/a}</li>
		{/foreach}
		</ul>
	</section>
{/if}

{if !$page->isIndexable()}
	{content for=head}
		<meta name="robots" content="noindex,nofollow,noarchive">
	{/content}
{/if}
