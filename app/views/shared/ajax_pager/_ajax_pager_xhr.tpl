{
	"count": {count($finder->getRecords())},
	"offset": {$pager->offset},
	"pageSize": {$pager->pageSize()},
	"forceReplace": {!($pager->isXhrOrdered()) ? ("true") : ("false") },
	"items": {jstring}{render partial='shared/ajax_pager/ajax_pager_list'}{/jstring}{if $gtm},
	"callback": {jstring}{render partial="shared/marketing/google_tag_manager_pager_function"}{/jstring}{/if}
}