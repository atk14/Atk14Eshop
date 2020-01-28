<?php
require_once(ATK14_DOCUMENT_ROOT.'atk14/src/atk14/helpers/block.a_remote.php');
require_once(ATK14_DOCUMENT_ROOT.'atk14/src/atk14/helpers/block.a.php');

function smarty_block_a_params($params,$content,$template,&$repeat){
	if(isset($params['_params'])) {
		$params += $params['_params'];
		unset($params['_params']);
	}

	if(key_exists('_remote',$params)) {
		unset($params['_remote']);
		return smarty_block_a_remote($params,$content,$template,$repeat);
	} else {
		return smarty_block_a($params,$content,$template,$repeat);
	}

}
