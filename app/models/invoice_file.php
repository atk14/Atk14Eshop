<?php
class InvoiceFile extends ApplicationModel implements Rankable {

	const TYPE_INVOICE = 1;
	const TYPE_STORNO = 2;
	const TYPE_PROFORMA = 3;

	static function GetInstancesForOrder($order){
		return self::FindAll("order_id",$order);
	}

	/**
	 *
	 *	$invoice_file = InvoiceFile::CreateNewRecord(["order_id" => 123, "content" => "pdf content", ....]);
	 */
	static function CreateNewRecord($values,$options = array()){
		$values += [
			"id" => null,
			"secret" => (string)String4::RandomString(10),
			"order_id" => null,

			"content" => null,
			"filename" => "faktura.pdf",
		];

		if(is_null($values["id"])){
			$values["id"] = self::GetNextId();
		}

		$content = $values["content"];
		unset($values["content"]);

		if($content){
			$order = Cache::Get("Order",$values["order_id"]);
			myAssert($order);

			// pro pripadne inkrementalni zalohovani je dobre pracovat s created_at a nikoli s document_date
			$date = Date::ByDate($order->getCreatedAt());

			$path = [
				$date->toString("Y"),
				$date->toString("m"),
				$values["id"].".dat",
			];
			if(TEST){
				array_unshift($path,"test");
			}

			$path = join("/",$path);

			$full_path = INVOICES_DIRECTORY . "/" . $path;
			Files::MkdirForFile($full_path,$err);
			myAssert(!$err);
			Files::WriteToFile($full_path,$content,$err);
			myAssert(!$err);

			$values["path"] = $path;
			$values["filesize"] = strlen($content);
			$values += [
				"mime_type" => Files::DetermineFileType($full_path),
				"filename" => "invoice.pdf",
			];
		}

		return parent::CreateNewRecord($values,$options);
	}

	static function CreateNewRecordByUploadedFile($file,$values,$options = array()){
		$content = $file->getContent();

		$values["content"] = $content;
		$values["filename"] = $file->getFileName();
		$values["mime_type"] = $file->getMimeType();

		return self::CreateNewRecord($values);

		$values += [
			"id" => null,
			"order_id" => null,
			"document_date" => null,
		];

		if(is_null($values["id"])){
			$values["id"] = self::GetNextId();
		}

		$order = Cache::Get("Order",$values["order_id"]);
		myAssert($order);

		// pro pripadne inkrementalni zalohovani je dobre pracovat s created_at a nikoli s document_date
		$date = Date::ByDate($order->getCreatedAt());

		$path = [
			$date->toString("Y"),
			$date->toString("m"),
			$values["id"].".dat",
		];
		if(TEST){
			array_unshift($path,"test");
		}
		$path = join("/",$path);

		$full_path = INVOICES_DIRECTORY . "/" . $path;
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

	function setRank($rank){
		return $this->_setRank($rank,["order_id" => $this->g("order_id")]);
	}

	function getOrder(){ return Cache::Get("Order",$this->getOrderId()); }

	function getDateOfIssue(){
		return $this->getDocumentDate();
	}

	function getFullPath(){ return INVOICES_DIRECTORY."/".$this->getPath(); }

	function getContent(){
		if(!file_exists(INVOICES_DIRECTORY)){
			Files::Mkdir(INVOICES_DIRECTORY,$err);
			myAssert(!$err);
		}

		$content = Files::GetFileContent($this->getFullPath(),$err);
		myAssert(!$err,"File must exists and be must be readable: ".$this->getFullPath());
		return $content;
	}

	function getInvoice(){
		return Cache::Get("Invoice",$this->getInvoiceId());
	}

	function getToken($options = array()){
		if(is_string($options)){
			$options = array("extra_salt" => $options);
		}
		$options += array(
			"salt" => $this->getSecret().$this->getId(),
		);
		return parent::getToken($options);
	}

	function getUrl($options = []){

		$options += [
			"for_administrator" => false,
		];
	
		$order = $this->getOrder();
		($region = $order->getRegion()) || ($region = Region::GetDefaultRegion());
		$with_hostname = PRODUCTION ? $region->getDefaultDomain() : true;

		$params = [
			"namespace" => "",
			"controller" => "invoice_files",
			"action" => "detail",
			"lang" => $region->getDefaultLanguage(),
			"filename" => $this->getFilename(),
			"token" => $this->getToken(["extra_salt" => "invoice_detail"]),
		];

		if($options["for_administrator"]){
			// pouzije se akt. jazyk
			unset($params["lang"]);
			// pouzije se akt. domena, na ktere je admin prihlaseny
			$with_hostname = true;
		}
		
		return Atk14Url::BuildLink($params,[
			"with_hostname" => $with_hostname,
			"ssl" => REDIRECT_TO_SSL_AUTOMATICALLY,
		]);
	}

	function isRegularInvoice(){
		return $this->getInvoiceType()===self::TYPE_INVOICE;
	}

	function isProformaInvoice(){
		return $this->getInvoiceType()===self::TYPE_PROFORMA;
	}

	function isStornoInvoice(){
		return $this->getInvoiceType()===self::TYPE_STORNO;
	}

	function isDeletable(){
		return true;
	}

	function destroy($destroy_for_real = null){
		$ret = parent::destroy();
		Files::Unlink($this->getFullPath());
		return $ret;
	}
}
