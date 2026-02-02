<?php
/**
 *
 *	{$body|remove_empty_lines}
 *	{$body|remove_empty_lines:"max_empty_lines=2"}
 */
function smarty_modifier_remove_empty_lines($content,$options = []){
	$options = Atk14Utils::StringToOptions($options);
	return String4::ToObject($content)->removeEmptyLines($options)->toString();
}
