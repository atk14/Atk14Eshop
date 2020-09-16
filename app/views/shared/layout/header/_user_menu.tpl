<ul class="navbar-nav user-menu">
	{if $logged_user}
		{* user is logged in *}
		{capture assign=user_profile_url}{link_to namespace="" controller=users action="detail"}{/capture}
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				{!"user"|icon}<span class="d-none d-sm-inline"> {$logged_user->getLogin()}</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
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
		<li class="nav-item"><a href="{link_to namespace="" action="logins/create_new"}" class="nav-link">{!"user"|icon} {t}Sign in{/t}</a></li>
	{/if}
</ul>