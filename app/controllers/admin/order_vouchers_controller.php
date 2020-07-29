<?php
class OrderVouchersController extends AdminController {

	function create_new(){
		$order = $this->order;
		$this->_create_new([
			"page_title" => _("Přidat slevový kupón objednávce"),
			"create_closure" => function($d) use($order){
				if(OrderVoucher::FindFirst("order_id",$order,"voucher_id",$d["voucher_id"])){
					$this->form->set_error("voucher_id",_("Tento slevový kupón již objednávka obsahuje"));
					return;
				}

				$d["order_id"] = $order;
				$d["created_administratively"] = true;
				$ret = OrderVoucher::CreateNewRecord($d);
				$order->recalculatePriceToPay();
				return $ret;
			}
		]);	
	}

	function edit(){
		$order = $this->order;
		$this->_edit([
			"page_title" => _("Editace slevového kupónu u objednávky"),
			"update_closure" => function($order_voucher,$d) use($order){
				$ret = $order_voucher->s($d);
				$order->recalculatePriceToPay();
				return $ret;
			}
		]);
	}

	function destroy(){
		$order = $this->order;
		$this->_destroy([
			"destroy_closure" => function($order_voucher) use($order){
				$order_voucher->destroy();
				$order->recalculatePriceToPay();
			},
			"redirect_to" => $this->_get_return_uri(),
		]);
	}

	function _before_filter(){
		$order = null;

		if(in_array($this->action,["create_new"])){
			$order = $this->_find("order","order_id");
		}

		if(in_array($this->action,["edit","destroy"])){
			($order_voucher = $this->_find("order_voucher")) && ($order = $order_voucher->getOrder());
		}

		$this->order = $order;

		$this->_add_order_to_breadcrumb($order);
	}
}
