<?php
function smarty_modifier_anonymize_email($email){
	$email = (string)$email;
	if(!strlen($email)){ return $email; }

	$email = preg_replace_callback('/^(.)(.*?)(.)@/',function($matches){
		return $matches[1].str_repeat(".",max(strlen($matches[2]),3)).$matches[3]."@";
	},$email);

	return $email;
}
