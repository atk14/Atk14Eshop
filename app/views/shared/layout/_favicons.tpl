{*
	favicons.
	see https://www.emergeinteractive.com/insights/detail/the-essentials-of-favicons/ 
*}
{assign image_url "app.favicon"|system_parameter}
{if $image_url}

{* oldschool *}
<link rel="shortcut icon" href="{$image_url|to_favicon_url}}">
{* generics *}
<link rel="icon" href="{$image_url|img_url:"!32x32"}" sizes="32x32">
<link rel="icon" href="{$image_url|img_url:"!57x57"}" sizes="57x57">
<link rel="icon" href="{$image_url|img_url:"!76x76"}" sizes="76x76">
<link rel="icon" href="{$image_url|img_url:"!96x96"}" sizes="96x96">
<link rel="icon" href="{$image_url|img_url:"!128x128"}" sizes="128x128">
<link rel="icon" href="{$image_url|img_url:"!192x192"}" sizes="192x192">
<link rel="icon" href="{$image_url|img_url:"!228x228"}" sizes="228x228">
{* Android *}
<link rel="shortcut icon" sizes="196x196" href="{$image_url|img_url:"!196x196"}">
{* iOS *}
<link rel="apple-touch-icon" href="{$image_url|img_url:"!120x120"}" sizes="120x120">
<link rel="apple-touch-icon" href="{$image_url|img_url:"!152x152"}" sizes="152x152">
<link rel="apple-touch-icon" href="{$image_url|img_url:"!180x180"}" sizes="180x180">
{* Windows 8 IE 10 *}
<meta name="msapplication-TileColor" content="#FFFFFF">
<meta name="msapplication-TileImage" content="{$image_url|img_url:"!144x144"}">

{/if}
