<nav aria-label="breadcrumb" class="nav--breadcrumb">
<ol class="breadcrumb">
	{foreach $breadcrumbs as $breadcrumb}
		<li class="breadcrumb-item">
			{if $breadcrumb->getUrl() && !$breadcrumb@last}
				<a href="{$breadcrumb->getUrl()}">{if $breadcrumb@first}{!"home"|icon}{/if}{$breadcrumb->getTitle()}</a>
			{else}
				{$breadcrumb->getTitle()}
			{/if}
		</li>
	{/foreach}
</ol>
</nav>
