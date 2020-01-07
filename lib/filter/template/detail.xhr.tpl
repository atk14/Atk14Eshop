{*//#TODO js
//pokud bezi dalsi request, tak nic neprekreslujeme*}
(function() {
if( --$("#filter_form")[0].filtering == 0 ) {
	$('#cards').html({jstring}{render finder=$finder partial='shared/products_list'}{/jstring});
	{if !$finder->getPager()->isXhr()}
	$('#filter_fields').html({jstring}{render partial="shared/filter/filter_fields"}{/jstring});
	var form=$('#paging_form');
	form.attr('action',{jstring}{$paging_form->get_action()}{/jstring});
	$('#active_filters').html({jstring}{render partial='shared/filter/active_filters' filter=$finder->filter}{/jstring});

	{*$('#child-categories').html({jstring}{render partial='child_categories'}{/jstring});*}

	ATK14COMMON.filter_init( '#filter_form', true );
	if( "NoUISlider" in window ) {
		NoUISlider.Init();
	}
	{/if}
	ATK14COMMON.Pager.init();
	var fce = form[0].wasFiltered ? window.history.replaceState : window.history.pushState;
	fce = fce.bind( window.history );
	fce({}, "", {jstring}{link_to_params path=$category->getPath() _connector='&' _params=$finder->filter->getParams()}{/jstring});
	//form[0].wasFiltered = true;
}
})();
