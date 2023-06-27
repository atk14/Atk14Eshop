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

		{cookie_consent_datalayer_command}

		<meta charset="utf-8">
	
		{!$head_tags}
		{render partial="shared/layout/performance_optimizations"}
		{render partial="shared/trackers/google/tag_manager_head"}
		{render partial="shared/trackers/google/analytics"}

		<title>{trim}
			{if $controller=="main" && $action=="index" && $namespace==""}
				{$page_title|strip_tags}
			{else}
				{$page_title|strip_tags} | {"ATK14_APPLICATION_NAME"|dump_constant}
			{/if}
		{/trim}</title>

		<meta name="description" content="{$page_description}">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		{if $browser_theme_color}
		<meta name="theme-color" content="{$browser_theme_color}">
		{/if}

		{if $DEVELOPMENT}
			{render partial="shared/layout/dev_info"}
		{/if}

		{* Indication of active javascript *}
		{javascript_tag}
			document.documentElement.className = document.documentElement.className.replace( /\bno-js\b/, "js" );
		{/javascript_tag}

		{stylesheet_link_tag file="$public/dist/styles/vendor.min.css" hide_when_file_not_found=true}
		{stylesheet_link_tag file="$public/dist/styles/application.min.css"}

		<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			{javascript_script_tag file="$public/dist/scripts/html5shiv.min.js"}
			{javascript_script_tag file="$public/dist/scripts/respond.min.js"}
		<![endif]-->

		{render partial="shared/layout/favicons"}
		
		{!"app.trackers.google.site_verification.html_tag"|system_parameter}

		{placeholder for=head} {* a place for <link rel="canonical" ...>, etc. *}
		{enhanced_conversion_data}
		{facebook_pixel}
	</head>

	<body class="body_{$controller}_{$action}" data-namespace="{$namespace}" data-controller="{$controller}" data-action="{$action}" data-scrollhideheader="false">
		{facebook_pixel part="body"}
		{render partial="shared/trackers/google/tag_manager_body"}
		<a href="#content-main" class="sr-only">{t}Skip to main content{/t}</a>
		<div class="bs-offcanvas-overlay"></div>
		{render partial="shared/layout/header"}
		{if defined("SIDEBAR_MENU_ENABLED") && constant("SIDEBAR_MENU_ENABLED") && $namespace=="" && ($controller=="main" || $controller=="categories" || $controller=="cards")}
			{assign use_sidebar_menu true}
		{/if}
		<div class="body--upper" >{placeholder for="out_of_container"}</div>
		<div class="body{if $section_navigation || $use_sidebar_menu} has-nav-section{/if}" id="page-body">
			{if $section_navigation || $use_sidebar_menu}<div class="body__sticky-container">{/if}
			{if $section_navigation}
				<nav class="nav-section">
					{render partial="shared/layout/section_navigation"}
				</nav>
			{elseif $use_sidebar_menu}
				<nav class="nav-section">
					{render partial="shared/layout/sidebar_nav"}
				</nav>
			{/if}
			<div class="container-fluid">

				{if $breadcrumbs && sizeof($breadcrumbs)>=2} {* It makes no sense to display breadcrumbs with just 1 or no element *}
					{render partial="shared/breadcrumbs"}
				{/if}

				<div class="content-main" id="content-main">
					{render partial="shared/layout/flash_message"}
					{placeholder}
				</div>
			</div>
			{if $section_navigation || $use_sidebar_menu}</div>{/if}
		</div>
		{render partial="shared/layout/footer"}

		{render partial="shared/offcanvas_basket"}
		

		<div class="search-suggestions js--suggesting">
		<div class="suggestions__not-found">
		<p><em>{t}Searching...{/t}</em></p>
		</div>
		</div>

		{render partial="shared/cookie_consent/banner"}
		
		{render partial="shared/basket_info_float_container"}
		{render partial="shared/layout/devcssinfo"}

		{javascript_script_tag file="$public/dist/scripts/vendor.min.js"}
		{javascript_script_tag file="$public/dist/scripts/application.min.js"}
		{javascript_script_tag file="$public/dist/scripts/modules/application_es6.min.js" type="module"}

		{javascript_tag}
			{placeholder for="js"}
		{/javascript_tag}
		
		{if $controller=="styleguides"}
			<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism.min.css" rel="stylesheet" />
			<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/prism.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
		{/if}
	</body>
</html>
