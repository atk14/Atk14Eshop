<!DOCTYPE html>
<html lang="{$lang}" class="no-js">

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

		{if $DEVELOPMENT}
			{render partial="shared/layout/dev_info"}
		{/if}

		{* Indication of active javascript *}
		{javascript_tag}
			document.documentElement.className = document.documentElement.className.replace( /\bno-js\b/, "js" );
		{/javascript_tag}

		{stylesheet_link_tag file="$public/dist/styles/vendor.min.css" hide_when_file_not_found=true}
		{stylesheet_link_tag file="$public/dist/styles/default-skin/default-skin.css" hide_when_file_not_found=true}
		{stylesheet_link_tag file="$public/dist/styles/application.min.css"}

		<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			{javascript_script_tag file="$public/dist/scripts/html5shiv.min.js"}
			{javascript_script_tag file="$public/dist/scripts/respond.min.js"}
		<![endif]-->

		{render partial="shared/layout/favicons"}
		
		{!"app.trackers.google.site_verification.html_tag"|system_parameter}

		{placeholder for=head} {* a place for <link rel="canonical" ...>, etc. *}
		{facebook_pixel}
	</head>

	<body class="body_{$controller}_{$action}" data-namespace="{$namespace}" data-controller="{$controller}" data-action="{$action}">

			{placeholder}

	</body>
</html>
