{
	"count": {$pager->limit},
	"offset": {$pager->offset},
	"pageSize": {$pager->getPageSize()},
	"forceReplace": {!($pager->isXhrOrdered()) ? ("true") : ("false") },
	"items": {jstring}{render partial='shared/ajax_pager/ajax_pager_list'}{/jstring}
}
