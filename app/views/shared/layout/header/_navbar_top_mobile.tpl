{assign var=appname value="ATK14_APPLICATION_NAME"|dump_constant}

{capture assign=menu_collapse}{remove_if_contains_no_text}
<div class="collapse navbar-collapse" id="navTopMobileNavDropdown">

	{if $controller=="main" && $action=="index"}

		{* Homepage *}

		{render partial="shared/layout/header/nav_menu" menu=$lazy_loader.secondary_menu_mobile enable_dropdown_menus=false nav_class="navbar-nav nav--2col"}

	{else}

		{* Elsewhere *}

		{render partial="shared/layout/header/nav_menu" menu="main_menu" enable_dropdown_menus=false nav_class="navbar-nav nav--2col"}

		<div class="menu-separator"></div>

		{render partial="shared/layout/header/nav_menu" menu=$lazy_loader.secondary_menu_mobile enable_dropdown_menus=false nav_class="navbar-nav nav--scrollable"}

	{/if}

	{if sizeof(Region::GetInstances())>1 || $supported_languages}
		<div class="menu-separator"></div>
		<ul class="navbar-nav nav--inline">
			{render partial="shared/langswitch_navbar_expanded" show_language_names=true}
		</ul>
		<div class="menu-separator"></div>
		<ul class="navbar-nav">
		{render partial="shared/regionswitch_navbar"}
		</ul>
	{/if}

</div>
{/remove_if_contains_no_text}{/capture}

<nav class="navbar navbar-dark bg-brand navbar-expand-{$nav_breakpoint} d-{$nav_breakpoint}-none navbar-top navbar-top--mobile">
	<div class="container-fluid">

		<div class="nav__mobile-items d-md-none">
			{if $menu_collapse}
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navTopMobileNavDropdown" aria-controls="navTopMobileNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars">{!"bars"|icon}</span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close">{!"times"|icon}</span>
				</button>
			{/if}
			<div class="navbar-brand">
			{a action="main/index" namespace="" _title=$link_title _class="d-flex"}
				<img src="/public/dist/images/header-logo--mobile.svg" alt="{$appname}" height="80">
			{/a}
			{*a action="main/index" namespace="" _title=$link_title _class="navbar-brand__text"}
				{"app.name.short"|system_parameter}
			{/a*}
			</div>
			{if !$show_search_in_mobile && !$use_large_search_bar}
			<ul class="navbar-nav">
				<li class="nav-item"><a href="" class="nav-link js--search-toggle">{!"search"|icon}</a></li>
			</ul>
			{/if}
			{render partial="shared/layout/header/user_menu"}
			{!$basket_info}
		</div>
		
		{if !$use_large_search_bar}
		<form class="form-inline search-form-mobile {if $show_search_in_mobile} show{/if}" action="{link_to namespace="" action="searches/index"}" id="js--mobile_search_field">
			<input name="q" type="text" class="form-control js--search" placeholder="{t}Hledat{/t}" autocomplete="off" tabindex="10">
			<button type="submit" class="btn btn-primary" title="{t}Hledat{/t}" tabindex="11">{!"search"|icon}</button>
		</form>
		{/if}
	
		{!$menu_collapse}

	</div>
</nav>
