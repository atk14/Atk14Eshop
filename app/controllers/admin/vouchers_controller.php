<?php
class VouchersController extends AdminController {

	function index(){
		$this->page_title = _("Slevové kupóny");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];

		if($d["search"]){
			$ar = explode(',','id::VARCHAR,voucher_code,discount_amount::VARCHAR');
			$fields = "UPPER(COALESCE(".join(",'')||' '||COALESCE(",$ar).",''))";
			if($conds = FullTextSearchQueryLike::GetQuery($fields,Translate::Upper($d["search"]),$bind_ar)){
				$this->sorting->add("search","voucher_code LIKE UPPER(:search)||'%' DESC");
				$bind_ar[":search"] = $d["search"];
				$conditions[] = $conds;
			}
		}

		$this->sorting->add("created_at",["reverse" => true]);
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
		if($this->request->get()){
			$this->form->set_initial("voucher_code",Voucher::PrepareVoucherCode());
		}

		$this->_create_new([
			"page_title" => _("Nový slevový kupón"),
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace slevového kupónu"),
		]);
	}

	function destroy(){
		$this->_destroy();
	}
}
