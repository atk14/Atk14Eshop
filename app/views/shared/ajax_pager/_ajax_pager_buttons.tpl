<div class="">
	<a href="{$pager->previousPageUrl()}" class="list__item js--previous btn btn-primary {if !$pager->previousPage()}disabled{/if}" rel="nofollow">{!"chevron-left"|icon} {$pager->getText('previous_page')}</a>
	<a href="{$pager->firstPageUrl()}" class="list__item js--first btn btn-default {if !$pager->firstPage()}disabled{/if}" rel="nofollow">{!"chevron-left"|icon}{!"chevron-left"|icon} {$pager->getText('first_page')}</a>
	<a href="{$pager->nextPageUrl()}" class="list__item js--next btn btn-primary {if !$pager->nextPage()}disabled{/if}" rel="nofollow">{$pager->getText('next_page', $pager->getRemains())} {!"chevron-right"|icon}</a>
</div>
<div class="pagination-info js--remains">{$pager->getText('remain', $pager->getRemains(), $pager->getTotal())}</div>
