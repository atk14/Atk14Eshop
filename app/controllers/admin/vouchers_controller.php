<?php
class VouchersController extends AdminController {

	function index(){
		$this->page_title = _("Slevové kupóny");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];

		if($d["search"]){
			$ar = [
				"id::VARCHAR",
				"voucher_code",
				"discount_amount::VARCHAR",
				"regions::VARCHAR",
			];
			$fields = "UPPER(COALESCE(".join(",'')||' '||COALESCE(",$ar).",''))";
			if($conds = FullTextSearchQueryLike::GetQuery($fields,Translate::Upper($d["search"]),$bind_ar)){
				$this->sorting->add("search","voucher_code LIKE UPPER(:search)||'%' DESC");
				$bind_ar[":search"] = $d["search"];
				$conditions[] = $conds;
			}
		}

		$this->sorting->add("created_at","created_at DESC, id DESC");
		$this->sorting->add("voucher_code");
		$this->sorting->add("discount","discount_percent ASC, discount_amount ASC, voucher_code ASC","discount_percent DESC, discount_amount DESC, voucher_code ASC");
		$this->sorting->add("active","active DESC, voucher_code ASC","active ASC, voucher_code ASC");
		$_used = "(SELECT COUNT(*) FROM order_vouchers WHERE order_vouchers.voucher_id=vouchers.id)>0";
		$this->sorting->add("used","$_used DESC, voucher_code ASC","$_used ASC, voucher_code ASC");

		$this->tpl_data["finder"] = Voucher::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"offset" => $this->params->getInt("offset"),
			"order_by" => $this->sorting, 
		]);
	}

	function create_new(){
		$this->page_title = _("Nový slevový kupón");

		$this->_walk([
			"save_return_uri",
			"get_voucher_type",
			"get_order",
			"get_order_item",
			"get_data",
			"save",
		]);
	}

	function create_new__save_return_uri(){
		$this->_next_step($this->_get_return_uri());
	}

	function create_new__get_voucher_type(){
		if($this->request->post() && ($d = $this->form->validate($this->params))){
			return $d["voucher_type"];
		}
	}

	function create_new__get_order(){
		if($this->returned_by["get_voucher_type"]!=="gift_card" || $this->params->defined("skip")){
			return ["order" => null];
		}

		$this->page_title .= " - "._("dárkový poukaz");

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			return ["order" => $d["order"]];
		}
	}

	function create_new__get_order_item(){
		$order = $this->returned_by["get_order"]["order"];
		if(!$order){
			return ["order_item" => null];
		}

		$this->page_title .= " - "._("dárkový poukaz");

		$this->form->tune_for_order($order);

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			return ["order_item" => $d["order_item"]];
		}
	}

	function create_new__get_data(){
		$order_item = $this->returned_by["get_order_item"]["order_item"];
		if($this->returned_by["get_voucher_type"]=="gift_card"){
			$this->page_title .= " - "._("dárkový poukaz");
			$this->form->tune_for_gift_voucher($order_item);
		}else{
			$this->page_title .= " - "._("slevový poukaz");
		}

		if($this->request->get()){
			$this->form->set_initial("voucher_code",Voucher::PrepareVoucherCode());
		}

		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$d["gift_voucher"] = $this->returned_by["get_voucher_type"]=="gift_card";
			$d["originator_order_item_id"] = $order_item ? $order_item->getId() : null;
			return $d;
		}
	}

	function create_new__save(){
		Voucher::CreateNewRecord($this->returned_by["get_data"]);
		$this->_redirect_to($this->returned_by["save_return_uri"]);
	}

	function edit(){
		$page_title = _("Editace slevového poukazu");
		if($this->voucher->isGiftVoucher()){
			$this->form->tune_for_gift_voucher();
			$page_title .= " ("._("dárkový poukaz").")";
		}else{
			$page_title .= " ("._("slevový poukaz").")";
		}

		$this->_edit([
			"page_title" => $page_title,
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("voucher");
		}
	}
}
