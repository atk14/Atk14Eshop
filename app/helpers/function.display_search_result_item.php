<?php
/**
 * Function designed for SearchesController to display a searched document
 *
 *	{display_search_result_item item=$item}
 *
 *	{display_search_result_item item=$item suggestion=true}
 *
 */
function smarty_function_display_search_result_item($params,$template){
	$params += [
		"item" => null,
		"suggestion" => false,
	];

	$item = $params["item"];
	if(!$item){ return; }

	$object = $item->getObject();
	if(!$object){ return; }

	$suggestion = $params["suggestion"];

	$class = get_class($object); // "Article"
	$object_name = String4::ToObject($class)->underscore()->toString(); // "Article" -> "article"

	$_tpl = "shared/search_result_items/_$object_name.tpl";

	if( $suggestion && $template->templateExists( "shared/search_result_items/_$object_name.suggestion.tpl" ) ){
		$_tpl = "shared/search_result_items/_$object_name.suggestion.tpl";
	}

	if(!$template->templateExists($_tpl)){
		trigger_error("No search template for $object_name (expected $_tpl)");
		return;
	}

	$template->assign($object_name,$object);
	$out = $template->fetch($_tpl);
	$template->clearAssign($object_name);

	return $out;
}
