<article>

	{if $page}

		<header>
			<h1>{$page->getTitle()}</h1>
			<div class="teaser">
			{!$page->getTeaser()|markdown}
			</div>
		</header>
		
		{!$page->getBody()|markdown}
			
	{else}

		<header>
			<h1>{$page_title}</h1>
		</header>

	{/if}

</article>

{content for="out_of_container"}
	{render partial="shared/slider" slider=$slider}
{/content}
