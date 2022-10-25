Sidebar Navigation
==================

Sidebar category navigation enhanced with sticky scrolling behavior for better UX

## How to enable sidebar navigation

1. In <code>/config/settings.php</code> file set value of <code>SIDEBAR_MENU_ENABLED</code> to <code>true</code>
2. In <code>gulpfile.js</code> enable Sticky Sidebar Javascript by uncommenting following line in <code>vendorScripts</code> array definition: 
   <code>"node_modules/sticky-sidebar-v2/dist/sticky-sidebar.js"</code>
3. Adjust <code>$sidebar-collapse-breakpoint</code> variable in <code>/public/styles/_application_variables.scss</code> file  as needed