<ul class="navbar-nav">
  <li class="nav-item dropdown quick-add-menu">
    <a href="#" class="nav-link dropdown-toggle" title="{t}Quick add{/t}" data-bs-toggle="dropdown" role="button" aria-expanded="false">{!"circle-plus"|icon:"solid"}</a>
    <div class="dropdown-menu dropdown-menu-end">
      <span class="dropdown-item">{t}Add new:{/t}</span>
      <div class="dropdown-divider"></div>
      {a controller="articles" action="create_new" _class="dropdown-item"}{t}Article{/t}{/a}
      {a controller="pages" action="create_new" _class="dropdown-item"}{t}Page{/t}{/a}
      {a controller="cards" action="create_new" _class="dropdown-item"}{t}Product{/t}{/a}
    </div>
  </li>
</ul>