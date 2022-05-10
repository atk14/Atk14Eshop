	<nav class="navbar navbar-dark bg-dark navbar-expand-{$nav_breakpoint} d-none d-{$nav_breakpoint}-block navbar-top navbar-top--desktop">
		<div class="container-fluid">
			{*<div class="navbar-brand">
				{a namespace="" controller="main" action="index" _class="navbar-brand__text"}{"app.name"|system_parameter}{/a}
			</div>*}
			<div class="collapse navbar-collapse" id="navTopDesktopNavDropdown">
				
				<div class="menu-separator"></div>
					
				{render partial="shared/layout/header/nav_menu" menu="secondary_menu" enable_dropdown_menus=false nav_class="navbar-nav" dropdown_class="dropdown-menu--dark dropdown-menu--transparent bg-dark"}
				
				<div class="menu-separator"></div>
				
				{render partial="shared/layout/header/user_menu" dropdown_class="dropdown-menu--dark dropdown-menu--transparent bg-dark"}
								
				{if sizeof($allowed_regions)>1 || sizeof($supported_languages)>0}
					<div class="menu-separator"></div>
					<ul class="navbar-nav">
					{if sizeof($allowed_regions)>1}
						{render partial="shared/regionswitch_navbar" dropdown_class="dropdown-menu--dark dropdown-menu--transparent bg-dark"}
					{/if}
					{if sizeof($supported_languages)>0}
						{render partial="shared/langswitch_navbar" dropdown_class="dropdown-menu--dark dropdown-menu--transparent bg-dark"}
					{/if}
				</ul>
				{/if}
				
			</div>
			
		</div>
	</nav>
