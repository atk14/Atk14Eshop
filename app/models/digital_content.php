<?php
class DigitalContent extends ApplicationModel implements Translatable, Rankable {

	use TraitRegions;

	static function GetTranslatableFields(){
		return ["title"];
	}

	static function CreateNewRecordByUploadedFile($file,$values,$options = array()){
		$values += [
			"id" => null,
			"created_at" => now(),
		];

		if(is_null($values["id"])){
			$values["id"] = self::GetNextId();
		}

		$date = Date::ByDate($values["created_at"]);
		myAssert($date,"created_at must be a date: $values[created_at]");

		$path = [
			$date->toString("Y"),
			$date->toString("m"),
			$values["id"].".dat",
		];
		if(TEST){
			array_unshift($path,"test");
		}
		$path = join("/",$path);

		$full_path = DIGITAL_CONTENTS_DIRECTORY . "/" . $path;
		Files::MkdirForFile($full_path);
		$stat = $file->moveTo($full_path);
		myAssert($stat);

		// set perm from 0600 to (by default) 0666
		$stat = Files::NormalizeFilePerms($full_path);
		myAssert($stat);

		$values["path"] = $path;
		$values["filename"] = $file->getFileName();
		$values["filesize"] = $file->getFileSize();
		$values["mime_type"] = $file->getMimeType();

		return self::CreateNewRecord($values,$options);
	}

	/**
	 *
	 *	$dc = DigitalContent::CreateNewRecordByFile("/home/yarri/www/dumlatek/robots/../tmp/strihy/95150-BASIC-Damska-bunda-32-46.zip",[
	 *		"product_id" => $product,
	 *		"regions" => '{"CR":true,"SK":true,"EU":true}'
	 *	]);
	 */
	static function CreateNewRecordByFile($filepath,$values,$options = array()){
		$values += [
			"id" => null,
			"created_at" => now(),
		];

		if(is_null($values["id"])){
			$values["id"] = self::GetNextId();
		}

		$date = Date::ByDate($values["created_at"]);
		myAssert($date,"created_at must be a date: $values[created_at]");

		myAssert(file_exists($filepath));
		
		$filename = preg_replace('/^.*\/(.+?)$/','\1',$filepath); // "/home/yarri/www/dumlatek/robots/../tmp/strihy/95150-BASIC-Damska-bunda-32-46.zip" -> "95150-BASIC-Damska-bunda-32-46.zip"

		$path = [
			$date->toString("Y"),
			$date->toString("m"),
			$values["id"].".dat",
		];
		if(TEST){
			array_unshift($path,"test");
		}
		$path = join("/",$path);

		$full_path = DIGITAL_CONTENTS_DIRECTORY . "/" . $path;
		Files::MkdirForFile($full_path);
		Files::CopyFile($filepath,$full_path,$err);
		myAssert(!$err);

		$values["path"] = $path;
		$values["filename"] = $filename;
		$values["filesize"] = filesize($filepath);
		$values["mime_type"] = Files::DetermineFileType($filepath);

		return self::CreateNewRecord($values,$options);
	}

	/**
	 * Vrati digitalni obsahy pro danou objednavku
	 */
	static function GetInstancesByOrder($order){
		$region = $order->getRegion();
		$region = $region ? $region : Region::GetDefaultRegion();

		$dbmole = self::GetDbmole();

		$ids = $dbmole->selectIntoArray("
			SELECT
				digital_contents.id
			FROM
				order_items,
				digital_contents
			WHERE
				order_items.order_id=:order AND
				digital_contents.product_id=order_items.product_id AND
				digital_contents.deleted=FALSE AND
				digital_contents.active AND
				(digital_contents.regions->>'$region')::BOOLEAN
			ORDER BY
				order_items.rank,
				order_items.id
		",[":order" => $order]);

		return Cache::Get("DigitalContent",$ids);
	}

	static function GetOrderTokenOptions(){
		return [
			"hash_length" => 16,
			"extra_salt" => SECRET_TOKEN."d00MnloadDigiCont3nt",
		];
	}

	/**
	 * Vrati options pro sestaveni tokenu objednavky a digitalniho obsahu
	 */
	static function GetDigitalContentTokenOptions($order){
		return [
			"hash_length" => 10,
			"extra_salt" => SECRET_TOKEN."d00MnloadDigiCont3nt_".$order->getOrderNo(),
		];
	}

	function setRank($rank){
		return $this->_setRank([
			"product_id" => $this->g("product_id"),
			"deleted" => false,
		]);
	}

	function getFullPath(){ return DIGITAL_CONTENTS_DIRECTORY."/".$this->getPath(); }

	function getSuffix(){
		$filename = $this->getFilename();
		$suffix = preg_replace('/^.*\.(.+?)$/','\1',$filename);
		return strtolower($suffix);
	}

	function getTitle($lang = null){
		$title = parent::getTitle($lang);
		if(strlen((string)$title)){ return $title; }
		return $this->getFilename();
	}

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}

	function getImageUrl(){
		$url = $this->g("image_url");
		if($url){ $url; }

		$product = $this->getProduct();
		$image = $product->getImage();
		if($image){ return $image->getUrl(); }
	}

	function isActive(){
		return $this->g("active");
	}

	function isDeleted(){
		$this->g("deleted");
	}

	function isDeletable(){
		return true;
	}

	function getDownloadUrl($order){
		global $ATK14_GLOBAL;

		$url = Atk14Url::BuildLink([
			//"lang" => $ATK14_GLOBAL->getDefaultLang(), // existuji routry pro vsecny jazyky
			"namespace" => "",
			"controller" => "digital_contents",
			"action" => "download",
			"order_token" => $order->getToken(self::GetOrderTokenOptions()),
			"token" => $this->getToken(self::GetDigitalContentTokenOptions($order)),
			"filename" => $this->getFilename(),
		],[
			"with_hostname" => true,
			"ssl" => PRODUCTION
		]);

		return $url;
	}

	function wasDownloaded($order){
		return !!DigitalContentDownload::FindFirst("order_id",$order,"digital_content_id",$this);
	}

	function destroy($destroy_for_real = null){
		$ret = parent::destroy();
		Files::Unlink($this->getFullPath());
		return $ret;
	}
}

myAssert(defined("DIGITAL_CONTENTS_DIRECTORY"),"DIGITAL_CONTENTS_DIRECTORY needs to be defined");
