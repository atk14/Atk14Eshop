<?php
function smarty_block_to_ascii($params,$content,$template,&$repeat){
	if($repeat){ return; }

	Atk14Require::Helper("modifier.to_ascii");
	return smarty_modifier_to_ascii($content);
}
