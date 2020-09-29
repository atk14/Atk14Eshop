	<nav class="navbar navbar-dark bg-dark navbar-expand-{$nav_breakpoint} d-none d-{$nav_breakpoint}-block navbar-top navbar-top--desktop">
		<div class="container-fluid">
			
			<div class="collapse navbar-collapse" id="navTopDesktopNavDropdown">
				
				<div class="menu-separator"></div>
					
				{render partial="shared/layout/header/nav_menu" menu="secondary_menu" nav_class="navbar-nav"}
				
				<div class="menu-separator"></div>
				
				{render partial="shared/layout/header/user_menu"}
								
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