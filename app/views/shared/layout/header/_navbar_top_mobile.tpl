{assign var=appname value="ATK14_APPLICATION_NAME"|dump_constant}

{capture assign=menu_collapse}{remove_if_contains_no_text}
<div class="collapse navbar-collapse" id="navTopMobileNavDropdown">

	{if $show_search_in_hamburger}
	<form class="form-inline navbar-search" action="{link_to namespace="" action="searches/index"}">
		<input name="q" type="text" class="form-control form-control-sm navbar-search-input" placeholder="{t}Hledat{/t}">
		<button type="submit" class="btn btn-sm btn-primary" title="{t}Hledat{/t}">{!"search"|icon}</button>
	</form>
	{/if}

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
			{a action="main/index" namespace="" _title=$link_title _class="xxnavbar-brand"}
				<img src="/public/dist/images/header-logo--mobile.svg" alt="{$appname}" width="220" height="80">
			{/a}
			</div>
			{if !$show_search_in_mobile}
			<ul class="navbar-nav">
				<li class="nav-item"><a href="" class="nav-link js--search-toggle">{!"search"|icon}</a></li>
			</ul>
			{/if}
			{render partial="shared/layout/header/user_menu"}
			{!$basket_info}
		</div>

		{!$menu_collapse}

	</div>
</nav>
