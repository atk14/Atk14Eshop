<?php
/**
 * Builds link to a page according to the given code or a Page object
 *
 *	<a href="{"about_us"|link_to_page}">About us</a>
 *	<a href="{$page|link_to_page}">About us</a>
 *	<a href="{$page|link_to_page:"with_hostname"}">About us</a>
 */
function smarty_modifier_link_to_page($code,$options = array()){
	if(is_object($code)){
		$page = $code;
	}else{
		$page = Page::GetInstanceByCode($code);
	}

	$options = Atk14Utils::StringToOptions($options);

	if(!$page){
		PRODUCTION && trigger_error("Unknown page code: $code", E_USER_WARNING);
		return Atk14Url::BuildLink(array("namespace" => "", "controller" => "main", "action" => "page_not_found", "page" => $code),$options);
	}

	return Atk14Url::BuildLink(array("namespace" => "", "controller" => "pages", "action" => "detail", "id" => $page),$options);
}
