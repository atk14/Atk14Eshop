{*
	Metadata for social sharing.
	TODO: 
		? dodelat pro dalsi typy obsahu (articles/index page/detail) - spise do budoucna pro obecne pouziti, viz https://developers.facebook.com/docs/sharing/webmasters#markup
*}
{if $controller=="articles" && $action=="detail"}
	{assign var="ogType" "article"}
	{assign var="ogTitle" $article->getTitle()}
	{assign var="ogDescription" $article->getTeaser()}
	{if $article->getImageUrl()}
		{assign var="ogImage" $article->getImageUrl()|img_url:"1200x628xcrop"}
	{else}
		{assign var="ogImage" "{$request->getServerUrl()}{$public}dist/images/default_social_image.jpg"}
	{/if}
{elseif $controller=="cards" && $action=="detail"}
	{assign var="ogType" "article"}
	{assign var="ogTitle" $card->getName()}
	{assign var="ogDescription" $card->getTeaser()}
	{if $card->getImage()}
		{assign var="ogImage" $card->getImage()|img_url:"1200x628xcrop"}
	{else}
		{assign var="ogImage" "{$request->getServerUrl()}{$public}dist/images/default_social_image.jpg"}
	{/if}
{elseif $controller=="pages" && $action=="detail"}
	{assign var="ogType" "article"}
	{assign var="ogTitle" $page->getTitle()}
	{assign var="ogDescription" $page->getTeaser()}
	{if $page->getImageUrl()}
		{assign var="ogImage" $page->getImageUrl()|img_url:"1200x628xcrop"}
	{else}
		{assign var="ogImage" "{$request->getServerUrl()}{$public}dist/images/default_social_image.jpg"}
	{/if}
{else}
	{assign var="ogImage" "{$request->getServerUrl()}{$public}dist/images/default_social_image.jpg"}
{/if}
	<meta property="og:url"           content="{$request->getUrl(["with_hostname" => true])}">
	<meta property="og:type"          content="{$ogType|default:"website"}">
{if $ogTitle}
	<meta property="og:title"         content="{$ogTitle}">
{else}
	<meta property="og:title"         content="{$page_title} | {"ATK14_APPLICATION_NAME"|dump_constant}">
{/if}
{if $ogDescription}
	<meta property="og:description"   content="{$ogDescription}">
{else}
	<meta property="og:description"   content="{$page_description}">
{/if}
{if $ogImage}
	<meta property="og:image"         content="{$ogImage}">
{/if}


