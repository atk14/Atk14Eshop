<?php
/**
 *
 *	{"app.name.official"|system_parameter}
 */
function smarty_modifier_system_parameter($code){
	if($sp = SystemParameter::GetInstanceByCode($code)){
		return $sp->getContent();
	}
}
