{capture assign="basket_info"}
	{render partial="shared/layout/header/basket_info"}
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
							</div>
						</li>
						{if $logged_user->isAdmin()}
							<li class="nav-item">
								{a action="main/index" namespace="admin" _class="nav-link"}{t}Administration{/t}{/a}
							</li>
						{/if}
				{else}
					<li class="nav-item"><a href="{link_to namespace="" action="logins/create_new"}" class="nav-link">{!"key"|icon} {t}Sign in{/t}</a></li>
					<li class="nav-item"><a href="{link_to namespace="" action="users/create_new"}" class="nav-link">{t}Register{/t}</a></li>
				{/if}

				{if sizeof(Region::GetInstances())>1}
					{foreach Region::GetInstances() as $region}
						<li class="nav-item{if $region->getId()==$current_region->getId()} active{/if}">
							{a namespace="" action="regions/set_region" id=$region _class="nav-link" _method="post" _rel="nofollow"}
								{$region->getName()}
							{/a}
						</li>
					{/foreach}
				{/if}

				</ul>
				
				<hr class="mobile-separator">
				
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
					{*render partial="shared/langswitch_navbar"*}
				</ul>
				
			</div>
			<div class="nav__desktop-items">
			{!$basket_info}
			</div>
		</div>
	</nav>
	<div class="logospace">
		{a action="main/index" namespace="" _title=$link_title _class="logospace__logo"}<img src="/public/dist/images/culek-logo-temp.svg" alt="{$appname}" width="350" height="100" class="img-fluid">{/a}
	</div>







	<nav class="navbar navbar-dark bg-success navbar-expand-{$nav_breakpoint} d-none d-{$nav_breakpoint}-flex navbar-main">
		<div class="container-fluid">

			
			<div class="collapse navbar-collapse justify-content-center" id="mainNavDropdown">
				{render partial="shared/layout/header/main_menu"}
			</div>
		</div>
	</nav>

</header>
