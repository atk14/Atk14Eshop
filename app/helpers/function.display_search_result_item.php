<?php
/**
 * Function designed for SearchesController to display a searched document
 *
 *	{display_search_result_item item=$item} {* $item is a Textmit\SearchResultItem *}
 *
 *	{display_search_result_item item=$item suggestion=true}
 *
 *	{display_search_result_item object=$object} {* $object is a ApplicationModel *}
 *
 */
function smarty_function_display_search_result_item($params,$template){
	$params += [
		"item" => null,
		"object" => null,
		"suggestion" => false,
	];

	$item = $params["item"];
	$object = $params["object"];
	if(!$item && !$object){ return; }

	$object = $item ? $item->getObject() : $object;
	if(!$object){ return; }

	if(method_exists($object,"isDeleted") && $object->isDeleted()){
		return;
	}

	$suggestion = $params["suggestion"];

	$class = get_class($object); // "Article"
	$object_name = String4::ToObject($class)->underscore()->toString(); // "Article" -> "article"
	
	$_tpl = "shared/search_result_items/_$object_name.card.tpl";

	if( $suggestion && $template->templateExists( "shared/search_result_items/_$object_name.suggestion.tpl" ) ){
		$_tpl = "shared/search_result_items/_$object_name.suggestion.tpl";
	}

	if(!$template->templateExists($_tpl)){
		trigger_error("No search template for $object_name (expected $_tpl)");
		return;
	}

	$template->assign($object_name,$object); // "article",$article
	$template->assign("object_type",$object_name); // "object_type","article"
	$out = $template->fetch($_tpl);
	$template->clearAssign($object_name);
	$template->clearAssign("object_type");

	return $out;
}
