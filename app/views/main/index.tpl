<article>

	{if $page}

		<header>
			{admin_menu for=$page}
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

{if $category_recommended_cards}
	{admin_menu for=$category_recommended_cards}
	<h3>{$category_recommended_cards->getName()}</h3>
	{if $category_recommended_cards->getTeaser()}
		<div class="lead">
			{!$category_recommended_cards->getTeaser()|markdown}
		</div>
	{/if}
	{if $category_recommended_cards->getDescription()}
		{!$category_recommended_cards->getDescription()|markdown}
	{/if}
	
	{render partial="shared/card_list" cards=$category_recommended_cards->getCards() title=""}
{/if}

{content for="out_of_container"}
	{render partial="shared/slider" slider=$slider}
{/content}

{if $page  && !$page->isIndexable()}
	{content for=head}
		<meta name="robots" content="noindex,noarchive">
	{/content}
{/if}
