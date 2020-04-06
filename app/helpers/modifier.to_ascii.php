<?php
/**
 * Converts content to ASCII.
 *
 *	{assign creature_name "Míša Kulička"}
 *	{$creature_name|to_ascii}
 *
 * It renders
 *
 *	Misa Kulicka
 *
 */
function smarty_modifier_to_ascii($content){
	return String4::ToObject($content)->toAscii()->toString();
}
