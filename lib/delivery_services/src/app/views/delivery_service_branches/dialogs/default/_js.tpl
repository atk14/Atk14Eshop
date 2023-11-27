// jak to navesit automaticky ??
window.UTILS.searchSuggestion(
	"js--delivery_branch_search_input",
	"js--delivery_branch_suggesting_area",
	{ hiding_suggesting_area: false }
);
setTimeout( function() {
	$( "#id_delivery_branch_search_q" ).focus();
},500);
