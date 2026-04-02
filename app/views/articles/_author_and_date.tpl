{assign author $article->getAuthor()}
{if $author}
		{if $author->getGender() && $author->getGender()->isFemale()}
			{t author=$article->getAuthor()->getName()|h date=$article->getPublishedAt() date_human=$article->getPublishedAt()|format_date escape=no}Posted by <!-- she --> <em>%1</em> on <time datetime="%2">%3</time>{/t}
		{else}
			{t author=$article->getAuthor()->getName()|h date=$article->getPublishedAt() date_human=$article->getPublishedAt()|format_date escape=no}Posted by <em>%1</em> on <time datetime="%2">%3</time>{/t}
		{/if}
{else}
	{t date=$article->getPublishedAt() date_human=$article->getPublishedAt()|format_date escape=no}Posted on <time datetime="%1">%2</time>{/t}
{/if}
