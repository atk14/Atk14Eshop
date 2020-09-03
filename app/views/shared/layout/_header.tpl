{*
 * Template for header.
 * $use_large_search_bar determines if large ful width search bar will be used.
 *}
{assign "use_large_search_bar" 0}
{capture assign="basket_info"}
	{render partial="shared/layout/header/basket_info" nav_class="navbar-nav"}
{/capture}
{* from which breakpoint up should menu be visible - value should be the same as in scss *}
{assign var=nav_breakpoint value="md"}
<header class="header-main">
	<nav class="navbar navbar-dark bg-dark navbar-expand-{$nav_breakpoint} nav-top">
		<div class="container-fluid">
			{assign var=appname value="ATK14_APPLICATION_NAME"|dump_constant}
			
			<div class="nav__mobile-items d-md-none">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bars">{!"bars"|icon}</span>
					<span class="icon-close">{!"times"|icon}</span>
				</button>
				<div class="nav__mobile__right">
					{!$basket_info}
				</div>
			</div>
			
			<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
				
				<form class="form-inline navbar-search" action="{link_to namespace="" action="searches/index"}">
					<input name="q" type="text" class="form-control form-control-sm navbar-search-input" placeholder="{t}Hledat{/t}">
					<button type="submit" class="btn btn-sm btn-primary" title="{t}Hledat{/t}">{!"search"|icon}</button>
				</form>
				
				
				<ul class="navbar-nav navbar-nav-main-mobile d-block d-{$nav_breakpoint}-none">
					{assign main_menu LinkList::GetInstanceByCode("main_menu")}
					{if $main_menu}
						{foreach $main_menu->getItems($current_region) as $item}
						<li class="nav-item"><a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a></li>
						{/foreach}
					{/if}
				</ul>
				
				<div class="menu-separator"></div>
				
				<ul class="navbar-nav xxnavbar-nav-main-mobile">
					{assign secondary_menu LinkList::GetInstanceByCode("secondary_menu")}
					{if $secondary_menu}
						{foreach $secondary_menu->getItems($current_region) as $item}
						<li class="nav-item"><a href="{$item->getUrl()}" class="nav-link">{$item->getTitle()}</a></li>
						{/foreach}
					{/if}
				</ul>
				
				<div class="menu-separator"></div>
				
				<ul class="navbar-nav">
					{if $logged_user}
						{* user is logged in *}
						{capture assign=user_profile_url}{link_to namespace="" controller=users action="detail"}{/capture}
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
								{!"user"|icon} {$logged_user->getLogin()}
							</a>
							<div class="dropdown-menu">
								{if $logged_user->isAdmin()}
									{a action="main/index" namespace="admin" _class="dropdown-item"}{!"wrench"|icon} {t}Administration{/t}{/a}
									<div class="dropdown-divider"></div>
								{/if}
								<a href="{$user_profile_url}" class="dropdown-item">{t}Profile{/t}</a>
								<a href="{link_to action="orders/index"}" class="dropdown-item">{t}My orders{/t}</a>
								<a href="{link_to action="delivery_addresses/index"}" class="dropdown-item">{t}Delivery addresses{/t}</a>
								<div class="dropdown-divider"></div>
								{a namespace="" action="logins/destroy" _method=post _class="dropdown-item"}{t}Sign out{/t}{/a}
								<div class="dropdown-divider"></div>
							</div>
						</li>
				{else}
					<li class="nav-item"><a href="{link_to namespace="" action="logins/create_new"}" class="nav-link">{!"key"|icon} {t}Sign in{/t}</a></li>
				{/if}
					
				<li class="menu-separator"></li>

				{render partial="shared/regionswitch_navbar"}
				{render partial="shared/langswitch_navbar"}

				</ul>
				
			</div>
			{*<div class="nav__desktop-items">
			{!$basket_info}
			</div>*}
		</div>
	</nav>	
	
	<div class="container-fluid header-main__mainbar">
		<div class="mainbar__controls">
			<div class="mainbar__top mainbar__links">
			</div>
			{if !$use_large_search_bar}
			<div class="mainbar__middle mainbar__search_cart">
				<form class="form-inline" action="{link_to namespace="" action="searches/index"}">
					<input name="q" type="text" class="form-control" placeholder="{t}Hledat{/t}">
					<button type="submit" class="btn btn-primary" title="{t}Hledat{/t}">{!"search"|icon}</button>
				</form>
				<div>
					{render partial="shared/layout/header/basket_info"}
				</div>
			</div>
			{/if}
			<div class="mainbar__bottom">
			</div>
	</div>
	<div class="logospace">
		{a action="main/index" namespace="" _title=$link_title _class="logospace__logo"}<img src="/public/dist/images/atk14-eshop.svg" alt="{$appname}" width="220" height="220" class="img-fluid">{/a}
	</div>
</div>






	<nav class="navbar navbar-dark bg-brand navbar-expand-{$nav_breakpoint} d-none d-{$nav_breakpoint}-flex navbar-main navbar--hoverable-dropdowns">
		<div class="container-fluid">

			
			<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">
				{render partial="shared/layout/header/main_menu"}
			</div>
		</div>
	</nav>
	
	{if $use_large_search_bar}
	{render partial="shared/layout/header/search_bar"}
	{/if}

</header>
