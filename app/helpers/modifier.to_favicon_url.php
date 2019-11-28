<?php
/**
 * Converts the given image URL (Pupuiq) to ico format and returns the new URL.
 *
 */
function smarty_modifier_to_favicon_url($image_url){
	if(!$image_url){ return; }

	$token = substr(md5($image_url),0,16);

	$ico_filename = TEMP."/favicons/$token/favicon.ico";

	if(!file_exists($ico_filename)){
		Files::MkdirForFile($ico_filename,$err,$err_str);
		myAssert(!$err,sprintf("Creating directory for favicon (%s)",$err_str));

		$uf = new UrlFetcher($image_url);
		if(!$uf->found()){
			trigger_error(sprintf("Downloading favicon from %s (%s)",$image_url,$uf->getErrorMessage()));
			return;
		}
		//myAssert($uf->found(),);

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

	return "/public/favicons/$token/favicon.ico?".filemtime($ico_filename);
}
