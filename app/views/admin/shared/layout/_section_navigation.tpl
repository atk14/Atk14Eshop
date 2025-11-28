<button class="btn btn-light nav-section__toggle">{t}Menu{/t} {!"angle-down"|icon}</button>
<div class="sidebar-toggle">
	<button class="btn btn-link js--sidebar-toggle"><span class="atk_icon atk_icon--sidebar"></span></button>
</div>
<div class="nav-section__collapsible">{* all things collapsible in mobile view go here *}
<form class="form-inline" id="nav-filter" autocomplete="off">
	<input class="form-control form-control-sm" id="nav-filter__input" placeholder="{t}search in menu{/t}">
	<button class="btn btn-sm btn-link d-none" id="nav-filter__clear" tabindex="-1">{!"times"|icon}</button>
	<button class="btn btn-sm btn-link" id="nav-filter__submit" tabindex="-1">{!"search"|icon}</button>
</form>
<ul class="nav nav-pills flex-column{if count($section_navigation)<15} nav--sticky{/if} js-filterable-nav">
	{foreach $section_navigation as $item}
		<li class="nav-item">
			<a class="nav-link{if $item->isActive()} active{/if}" href="{$item->getUrl()}">{$item->getTitle()}</a>
			<span class="d-none js-search-data">{$item->getTitle()} {$item->getTitle()|to_ascii}</span>
		</li>
	{/foreach}
</ul>
<div class="nav-section__collapsible">{* all things collapsible in mobile view go here *}