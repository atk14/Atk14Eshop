<?php
class DigitalContentsController extends AdminController {

	function index(){
		$this->page_title = sprintf(_("Soubory ke stažení u produktu %s"),$this->product->getName());

		$this->tpl_data["digital_contents"] = DigitalContent::FindAll("product_id",$this->product,"deleted",false);
	}

	function create_new(){
		$product = $this->product;
		$this->_create_new([
			"page_title" => sprintf(_("Nový soubor ke stažení u produktu %s"),$product->getName()),
			"create_closure" => function($d) use($product){
				$file = $d["file"];
				unset($d["file"]);
				$d["product_id"] = $product;
				return DigitalContent::CreateNewRecordByUploadedFile($file,$d);
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace souboru ke stažení"),
		]);
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function detail(){
		if($this->params->getString("format")!="raw"){
			return $this->_execute_action("error404");
		}

		$this->render_template = false;

		$this->response->setContentType($this->digital_content->getMimeType());
		$this->response->setHeader(sprintf('Content-Disposition: attachment; filename="%s"',$this->digital_content->getFilename()));
		$this->response->buffer->addFile($this->digital_content->getFullPath());
	}

	function _before_filter(){
		$product = null;
		if(in_array($this->action,["index","create_new"])){
			$product = $this->_find("product","product_id");
		}
		if(in_array($this->action,["edit","detail"])){
			$dc = $this->_find("digital_content");
			if($dc){ $product = $dc->getProduct(); }
		}

		if($product){
			$this->_add_card_to_breadcrumbs($product->getCard());
			$this->breadcrumbs[] = [sprintf(_("Soubory ke stažení")),$this->_link_to(["action" => "index", "product_id" => $product])];
		}
	}
}
