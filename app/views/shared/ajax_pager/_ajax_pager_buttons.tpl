<div class="">
	<a href="{$pager->firstPageUrl()}" class="list__item js--first btn btn-default {if !$pager->firstPage()}disabled{/if}"> {$pager->getText('first_page')}</a>
	<a href="{$pager->previousPageUrl()}" class="list__item js--previous btn btn-primary {if !$pager->previousPage()}disabled{/if}"> {$pager->getText('previous_page')}</a>
	<a href="{$pager->nextPageUrl()}" class="list__item js--next next-page btn btn-primary {if !$pager->nextPage()}disabled{/if}">{$pager->getText('next_page', $pager->getRemains())}</a>
</div>
<div class="pagination-info js--remains">{$pager->getText('remain', $pager->getRemains(), $pager->getTotal())}</div>

{render partial="shared/ajax_pager/paginator"}
