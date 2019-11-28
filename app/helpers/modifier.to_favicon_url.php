<?php
/**
 * Converts the given image (specified by an URL on Pupiq) to ico format and returns the new URL.
 *
 * Usage:
 *
 *	{$favicon_url} {* e.g. https://i.pupiq.net/i/65/65/6b8/2d6b8/1200x1200/BmlcpL_196x196xc_1d59b10db4762046.png *}
 *
 *	<link rel="shortcut icon" href="{$favicon_url|to_favicon_url}">
 *
 * It's required that in public directory is a symlink to tmp/favicons/.
 * Typically it can be ran the following command from the project directory:
 *
 *	ln -s ../tmp/favicons/ public/favicons
 *
 */
function smarty_modifier_to_favicon_url($image_url){
	global $ATK14_GLOBAL;

	if(!$image_url){ return; }

	$token = substr(md5($image_url),0,16);

	$ico_filename = TEMP."/favicons/$token/favicon.ico";

	if(!file_exists($ico_filename)){
		Files::MkdirForFile($ico_filename,$err,$err_str);
		myAssert(!$err,sprintf("Creating directory for favicon (%s)",$err_str));

		$uf = new UrlFetcher($image_url);
		if(!$uf->found()){
			// it's not a critical error
			trigger_error(sprintf("Downloading favicon from %s (%s)",$image_url,$uf->getErrorMessage()));
			return;
		}

		$image_filename = Files::WriteToTemp($uf->getContent(),$err);

		$sizes = [
			[16, 16],
			[24, 24],
			[32, 32],
			[48, 48],
		];
	
		$ico_lib = new PHP_ICO($image_filename,$sizes); // from package chrisjean/php-ico
		$ico_lib->save_ico($ico_filename);
		chmod($ico_filename,0666);

		Files::Unlink($image_filename,$err);
		myAssert(!$err);
	}

	return $ATK14_GLOBAL->getPublicBaseHref()."favicons/$token/favicon.ico?".filemtime($ico_filename);
}
