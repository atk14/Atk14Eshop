<div class='pager-buttons'>
<ul class='list'>
<li class='pager_button js--first'><a href="{$pager->firstPageUrl()}" class='btn btn-default {if !$pager->firstPage()}disabled{/if}'>{$pager->getText('first_page')}</a></li>

<li class='pager_button js--previous'><a href="{$pager->previousPageUrl()}" class='btn btn-default {if !$pager->previousPage()}disabled{/if}'>{$pager->getText('previous_page')}</a></li>

<li class='pager_button js--next'><a href="{$pager->nextPageUrl()}" class='btn btn-default {if !$pager->nextPage()}disabled{/if}'>{$pager->getText('next_page', $pager->getTotal())}</a></li>
</ul>
<div class='js--remains'>{$pager->getText('remain', $pager->getRemains(), $pager->getTotal())}</div>
</div>
