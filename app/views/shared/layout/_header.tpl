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
			
			<div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
				
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
				
				<hr class="mobile-separator">
				
				<ul class="navbar-nav">
					{if $logged_user}
						{* user is logged in *}
						{capture assign=user_profile_url}{link_to namespace="" controller=users action="detail"}{/capture}
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
								{!"user"|icon} {$logged_user->getLogin()}
							</a>
							<div class="dropdown-menu">
								<a href="{$user_profile_url}" class="dropdown-item">{t}Profile{/t}</a>
								<a href="{link_to action="orders/index"}" class="dropdown-item">{t}My orders{/t}</a>
								<a href="{link_to action="delivery_addresses/index"}" class="dropdown-item">{t}Delivery addresses{/t}</a>
								<div class="dropdown-divider"></div>
								{a namespace="" action="logins/destroy" _method=post _class="dropdown-item"}{t}Sign out{/t}{/a}
								<div class="dropdown-divider"></div>
							</div>
						</li>
						{if $logged_user->isAdmin()}
							<li class="nav-item">
								{a action="main/index" namespace="admin" _class="nav-link"}{!"wrench"|icon} {t}Administration{/t}{/a}
							</li>
						{/if}
				{else}
					<li class="nav-item"><a href="{link_to namespace="" action="logins/create_new"}" class="nav-link">{!"key"|icon} {t}Sign in{/t}</a></li>
				{/if}

				{render partial="shared/regionswitch_navbar"}

				{render partial="shared/langswitch_navbar"}

				</ul>
				
			</div>
			<div class="nav__desktop-items">
			{!$basket_info}
			</div>
		</div>
	</nav>	
	
	<div class="container-fluid header-main__mainbar">
		<div class="mainbar__controls">
			<div class="mainbar__links">
				<ul class="nav">
					{if $logged_user}
						{* user is logged in *}
						{capture assign=user_profile_url}{link_to namespace="" controller=users action="detail"}{/capture}
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
								{!"user"|icon} {$logged_user->getLogin()}
							</a>
							<div class="dropdown-menu">
								<a href="{$user_profile_url}" class="dropdown-item">{t}Profile{/t}</a>
								<a href="{link_to action="orders/index"}" class="dropdown-item">{t}My orders{/t}</a>
								<a href="{link_to action="delivery_addresses/index"}" class="dropdown-item">{t}Delivery addresses{/t}</a>
								<div class="dropdown-divider"></div>
								{a namespace="" action="logins/destroy" _method=post _class="dropdown-item"}{t}Sign out{/t}{/a}
							</div>
						</li>
						{if $logged_user->isAdmin()}
							<li class="nav-item">
								{a action="main/index" namespace="admin" _class="nav-link"}{!"wrench"|icon} {t}Administration{/t}{/a}
							</li>
						{/if}
					{else}
						<li class="nav-item"><a href="{link_to namespace="" action="logins/create_new"}" class="nav-link">{!"key"|icon} {t}Sign in{/t}</a></li>
					{/if}

					{render partial="shared/regionswitch_navbar"}

					{render partial="shared/langswitch_navbar"}

				</ul>
			</div>
			<div class="mainbar__search_cart">
				<form class="form-inline" action="{link_to namespace="" action="searches/index"}">
					<input name="q" type="text" class="form-control" placeholder="{t}Hledat{/t}">
					<button type="submit" class="btn btn-primary" title="{t}Hledat{/t}">{!"search"|icon}</button>
				</form>
				<div>
					{render partial="shared/layout/header/basket_info"}
				</div>
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
	
	
	{render partial="shared/layout/header/search_bar"}

</header>
