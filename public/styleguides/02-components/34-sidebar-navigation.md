Sidebar Navigation
==================

Sidebar category navigation enhanced with sticky scrolling behavior for better UX. On small viewports it is displayed as small expandable widget. See also [Collapsible Tree Vertical Menu Nav component](/styleguides/components%3Alist-tree/)

## How to enable sidebar navigation

1. In <code>/config/settings.php</code> file set value of <code>SIDEBAR_MENU_ENABLED</code> to <code>true</code>
2. In <code>gulpfile.js</code> enable Sticky Sidebar Javascript by uncommenting following line in <code>vendorScripts</code> array definition: 
   <code>"node_modules/sticky-sidebar-v2/dist/sticky-sidebar.js"</code>
3. Adjust <code>$sidebar-collapse-breakpoint</code> variable in <code>/public/styles/_application_variables.scss</code> file  as needed

[example]
<div class="body has-nav-section">
   <div class="body__sticky-container">
      <nav class="nav-section">
         <button class="sidebar-toggle js-sidebar-toggle"><span class="sidebar-toggle__text-hidden">Zobrazit
               kategorie</span><span class="sidebar-toggle__text-shown">Skrýt kategorie</span><span
               class="sidebar-toggle__icon"><span class="fas fa-chevron-down"></span></span></button>
         <ul class="nav nav--sidebar nav--sidebar--borders-sm" id="sidebar_menu" style="position: relative;">
      
            <li class="nav-item nav-item--has-submenu">
               <a href="#" class="nav-link">Květiny</a>
               <span class="expander  collapsed" role="button" id="sidebar_menu_item_35" data-toggle="collapse"
                  data-target="#sidebar_submenu_35" aria-expanded="false" aria-controls="sidebar_submenu_35"
                  aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
               <ul class="nav nav--sidebar__submenu collapse" id="sidebar_submenu_35" aria-labelledby="sidebar_menu_item_35">
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_36">Voňavé</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_37">Pichlavé</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_38">Domácí</a>
                  </li>
                  <li class="nav-item nav-item--has-submenu">
                     <a href="#" class="nav-link collapsed">Divoké</a>
                     <span class="expander  collapsed" role="button" id="sidebar_menu_item_39" data-toggle="collapse"
                        data-target="#sidebar_submenu_39" aria-expanded="false" aria-controls="sidebar_submenu_39"
                        aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
                     <ul class="nav nav--sidebar__submenu collapse" id="sidebar_submenu_39" aria-labelledby="sidebar_menu_item_39">
                        <li class="nav-item">
                           <a href="#" class="nav-link" id="sidebar_menu_item_70">Domácí</a>
                        </li>
                        <li class="nav-item">
                           <a href="#" class="nav-link" id="sidebar_menu_item_71">Exotické</a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </li>
      
            <li class="nav-item">
               <a href="#" class="nav-link" id="sidebar_menu_item_40">Retro</a>
            </li>
      
            <li class="nav-item">
               <a href="#" class="nav-link" id="sidebar_menu_item_41">Krabice, krabičky</a>
            </li>
      
            <li class="nav-item">
               <a href="#" class="nav-link" id="sidebar_menu_item_54">Zážitky</a>
            </li>
      
            <li class="nav-item">
               <a href="#" class="nav-link" id="sidebar_menu_item_68">Knihy</a>
            </li>
      
            <li class="nav-item nav-item--has-submenu">
               <a href="#" class="nav-link active">Hudba</a>
               <span class="expander  " role="button" id="sidebar_menu_item_69" data-toggle="collapse"
                  data-target="#sidebar_submenu_69" aria-expanded="true" aria-controls="sidebar_submenu_69"
                  aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
               <ul class="nav nav--sidebar__submenu collapse show" id="sidebar_submenu_69"
                  aria-labelledby="sidebar_menu_item_69">
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_72">Techno</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_73">Electro</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_81">Ambient</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_82">EBM</a>
                  </li>
               </ul>
            </li>
      
            <li class="nav-item nav-item--has-submenu">
               <a href="#" class="nav-link">Syntezátory</a>
               <span class="expander  collapsed" role="button" id="sidebar_menu_item_74" data-toggle="collapse"
                  data-target="#sidebar_submenu_74" aria-expanded="false" aria-controls="sidebar_submenu_74"
                  aria-label="Rozbalit podnabídku"><span class="fas fa-chevron-down"></span></span>
               <ul class="nav nav--sidebar__submenu collapse" id="sidebar_submenu_74" aria-labelledby="sidebar_menu_item_74">
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_85">Analogové</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_86">Modulární</a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link" id="sidebar_menu_item_88">Digitální</a>
                  </li>
               </ul>
            </li>
      
         </ul>
      </nav>
      <div class="container-fluid" style="min-height: 100%;">
         Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ligula est, ultrices lobortis euismod eu, aliquam a nisl. Praesent turpis purus, cursus vel magna at, ullamcorper rutrum tortor. Quisque condimentum dolor accumsan, sagittis quam non, volutpat justo. Nulla nec ex dolor. Donec nec rutrum nibh, at aliquam nibh. Donec ornare in lectus eu luctus. Duis dictum lectus nulla, ac congue magna vulputate ut.Proin tortor urna, vestibulum sit amet faucibus non, venenatis id massa. Sed ut suscipit nibh, sed consequat mauris. Etiam aliquam mauris ultrices, blandit enim sit amet, gravida nisl. Proin convallis pharetra sem, nec pellentesque lectus consequat at. Fusce tristique erat in velit tempor, id dictum risus pellentesque. Nullam sed euismod est, ut volutpat diam. Aenean consectetur dui enim, vitae feugiat enim pharetra non. Aliquam efficitur mattis ante et posuere. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vivamus egestas lectus sit amet dui dictum lacinia. Nam lacinia congue ex vel bibendum. Phasellus dapibus turpis id dapibus placerat. Donec at sem a nunc congue sagittis quis ac metus. Nunc sit amet velit turpis. Vestibulum eget porttitor ante. Sed mollis lacus a dui luctus vestibulum. Phasellus sit amet leo felis. Integer quis felis sed risus sagittis accumsan eu at arcu. Integer tempus sollicitudin velit vitae ultrices. In et luctus est, et volutpat ante. Cras rutrum vitae ante quis scelerisque. Vestibulum consectetur eget enim vitae tempus. Phasellus tristique enim eget arcu vestibulum, a viverra lorem imperdiet. Vivamus lectus tortor, venenatis quis orci vitae, tempus tristique orci. Morbi ullamcorper, mi eget eleifend tincidunt, urna felis sollicitudin lectus, venenatis sagittis mauris arcu vel eros. Vestibulum consectetur aliquam ante. Phasellus accumsan dapibus cursus. Nam euismod sapien lectus, et dignissim nisi consequat vitae. Nunc nec aliquam risus. Proin faucibus cursus ultrices. Nulla eget blandit felis, placerat ultricies odio. Nulla magna ante, luctus a placerat nec, condimentum id justo. Nunc gravida rhoncus quam a ultricies. Maecenas laoreet erat nunc, ut euismod ipsum consectetur nec. Sed lobortis egestas ligula. Vivamus auctor ultrices augue, vitae porta nunc ullamcorper ut. Donec maximus enim nec magna eleifend volutpat. Integer elementum, velit quis tristique viverra, odio metus bibendum urna, nec tristique justo augue in ligula. Vestibulum ullamcorper pellentesque lacus. Vivamus posuere nulla ut porta semper. Quisque at nibh lacinia, sagittis quam quis, vehicula massa. Quisque semper, diam in bibendum vestibulum, diam nunc vehicula odio, id malesuada neque mi id justo. Fusce laoreet nec est condimentum vestibulum. Ut ut eleifend mi, ut commodo libero. Donec condimentum fermentum orci eu egestas. Sed imperdiet porta erat vel pulvinar. Vivamus ut iaculis purus. Donec in felis vitae erat ultricies ultricies. 
      </div>
   </div>
</div>
[/example]