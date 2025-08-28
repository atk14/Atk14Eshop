<?php
class InvoiceFilesController extends AdminController {

	function create_new(){
		$order = $this->order;
		$this->_add_order_to_breadcrumb($order);
		$this->_create_new([
			"page_title" => sprintf(_("Nahrát fakturu k objednávce %s"),$order->getOrderNo()),
			"create_closure" => function($d) use($order) {
				$file = $d["file"];
				unset($d["file"]);
				$d["order_id"] = $order;
				InvoiceFile::CreateNewRecordByUploadedFile($file,$d);
			}
		]);
	}

	function edit(){
		$this->_add_order_to_breadcrumb($this->invoice_file->getOrder());
		$this->_edit();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(in_array($this->action,["create_new"])){
			$this->_find("order","order_id");
		}
		if(in_array($this->action,["edit"])){
			$this->_find("invoice_file");
		}
	}
}
