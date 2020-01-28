{assign active_filters $filter->getActiveFilters()}
{foreach $active_filters as $active}
{a_params _class='js--active-filter' _remote=1 path=$path _params=$active['params']}{$active['label']}{/a_params}
{/foreach}
{if count($active_filters)>=2}
{a_remote path=$path _class='js--active-filter'}Odstraň všechny filtry{/a_remote}
{/if}
