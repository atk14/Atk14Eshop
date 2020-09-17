	<nav class="navbar navbar-dark bg-brand navbar-expand-{$nav_breakpoint} d-{$nav_breakpoint}-none nav-top nav-top--mobile">
		<div class="container-fluid">
			{assign var=appname value="ATK14_APPLICATION_NAME"|dump_constant}
			
			<div class="nav__mobile-items d-md-none">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navTopMobileNavDropdown" aria-controls="navTopMobileNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler__icon navbar-toggler__icon--bars">{!"bars"|icon}</span>
					<span class="navbar-toggler__icon navbar-toggler__icon--close">{!"times"|icon}</span>
				</button>
				{a action="main/index" namespace="" _title=$link_title _class="navbar-brand"}
					<img src="/public/dist/images/atk14-eshop--inverse.svg" alt="{$appname}" width="220" height="220">
				{/a}
				{render partial="shared/layout/header/user_menu"}	
				<div class="nav__mobile__right">
					{!$basket_info}
				</div>
			</div>
			
			<div class="collapse navbar-collapse" id="navTopMobileNavDropdown">
				
				{if $show_search_in_hamburger}
				<form class="form-inline navbar-search" action="{link_to namespace="" action="searches/index"}">
					<input name="q" type="text" class="form-control form-control-sm navbar-search-input" placeholder="{t}Hledat{/t}">
					<button type="submit" class="btn btn-sm btn-primary" title="{t}Hledat{/t}">{!"search"|icon}</button>
				</form>
				{/if}
				
				{assign main_menu LinkList::GetInstanceByCode("main_menu")}
				{render partial="shared/layout/header/nav_menu" menu="main_menu" enable_dropdown_menus=false nav_class="navbar-nav navbar-nav-main-mobile nav--2col"}
				
				<div class="menu-separator"></div>
				
				{render partial="shared/layout/header/nav_menu" menu="secondary_menu_mobile" enable_dropdown_menus=false nav_class="navbar-nav nav--scrollable"}
				
				{if sizeof(Region::GetInstances())>1 || $supported_languages}
					<div class="menu-separator"></div>
					<ul class="navbar-nav">	
					{render partial="shared/regionswitch_navbar"}
					{render partial="shared/langswitch_navbar"}
					</ul>
				{/if}
				
			</div>
		</div>
	</nav>