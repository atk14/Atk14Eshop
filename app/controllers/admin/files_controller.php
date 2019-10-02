<?php
require_once(__DIR__ . "/iobjects_base.php");
class FilesController extends IobjectsBaseController{

	function detail(){
		parent::detail();
		$this->page_title = sprintf(_("File %s"),$this->file->getFilename());
	}
}
