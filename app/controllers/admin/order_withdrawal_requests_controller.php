<?php
class OrderWithdrawalRequestsController extends AdminController {

	function index(){
		$this->page_title = _("Žádosti o odstoupení od smlouvy");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];

		if($d["search"]){
	
			$q_up = Translate::Upper($d["search"]);

			$fields = [];
			$fields[] = "id";
			$fields[] = "(SELECT order_no FROM orders WHERE id=order_withdrawal_requests.order_id)";
			foreach([
				"firstname",
				"lastname",
				"email",
				"phone",
				"bank_account_number",
				"other_reason",
			] as $f){
				$fields[] = "COALESCE($f,'')";
			}

			$ft_cond = FullTextSearchQueryLike::GetQuery("UPPER(".join("||' '||",$fields).")",$q_up);
			if($ft_cond){
				$conditions[] = $ft_cond;
				$bind_ar[":search"] = $q_up;
			}
		}

		$this->sorting->add("created_at","created_at DESC, id DESC");

		$this->tpl_data["finder"] = OrderWithdrawalRequest::Finder(array(
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"offset" => $this->params->getInt("offset"),
			"order_by" => $this->sorting,
		));
	}

	function detail(){
		$this->_detail([
			"page_title" => function($order_withdrawal_request){ return sprintf(_("Žádost o odstoupení od smlouvy č. %s"),$order_withdrawal_request->getId()); },
		]);
	}
}
