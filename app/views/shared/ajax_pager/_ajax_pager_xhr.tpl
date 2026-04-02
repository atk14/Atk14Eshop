{
	"count": {count($finder->getRecords())},
	"offset": {$pager->offset},
	"pageSize": {$pager->getpageSize()},
	"forceReplace": {!($pager->isXhrOrdered()) ? ("true") : ("false") },
	"items": {jstring}{render partial='shared/ajax_pager/ajax_pager_list'}{/jstring},
	"paginator": {jstring}{render partial="shared/ajax_pager/paginator"}{/jstring}
}
