{*
 * The page Layout template
 *
 * Placeholders
 * ------------
 * head						 	located whithin the <head> tag
 * main							the main (or default) one
 * js_script_tags				place for javascript script tags
 * js							place for javascript code
 * domready						place for domready javascript code
 *
 * Variables
 * ------------
 * $lang
 * $controller
 * $action
 * $namespace
 * $logged_user
 * $page_description
 *
 * Constants
 * ------------
 * $DEVELOPMENT
 *}
<!DOCTYPE html>
<html lang="{$lang}" prefix="og: http://ogp.me/ns#" class="no-js" >

	<head>
		<meta charset="utf-8">

		<title>{$page_title|strip_tags} | {"ATK14_APPLICATION_NAME"|dump_constant}</title>

		<meta name="description" content="{$page_description}">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		{render partial="shared/layout/favicons"}

		{if $DEVELOPMENT}
			{render partial="shared/layout/dev_info"}
		{/if}

		{* Indication of active javascript *}
		{javascript_tag}
			document.documentElement.className = document.documentElement.className.replace( /\bno-js\b/, "js" );
		{/javascript_tag}

		{*stylesheet_link_tag file="$public/dist/styles/vendor.min.css" hide_when_file_not_found=true*}
		{*stylesheet_link_tag file="$public/dist/styles/application.min.css"*}
		{stylesheet_link_tag file="$public/dist/styles/vouchers.min.css"}

		{placeholder for=head} {* a place for <link rel="canonical" ...>, etc. *}
	</head>

	<body class="body_{$controller}_{$action}" data-controller="{$controller}" data-action="{$action}">
		{placeholder}
		{javascript_tag}
			{placeholder for="js"}
		{/javascript_tag}
	</body>
</html>
