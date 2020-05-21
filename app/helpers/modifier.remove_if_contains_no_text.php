<?php
function smarty_modifier_remove_if_contains_no_text($content){

	$_content = $content;
	$_content = strip_tags($_content);
	$_content = trim($_content);
	if(strlen($_content)>0){
		return $content;
	}
}
