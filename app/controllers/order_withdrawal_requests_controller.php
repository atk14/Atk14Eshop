<?php
class OrderWithdrawalRequestsController extends ApplicationController {

	function create_new(){
		$this->_prepare_create_new_title();

		$this->_walk([
			"get_order",
			"send_otp",
			"authorize",
			"get_data",
		]);
	}

	function _prepare_create_new_title(){
		if($this->logged_user){
			$this->breadcrumbs[] = [_("Můj účet"),$this->_link_to("users/detail")];
			$this->breadcrumbs[] = [_("Objednávky"),$this->_link_to("orders/index")];
		}
		$this->page_title = $this->breadcrumbs[] = _("Odstoupení od kupní smlouvy");
	}

	function create_new__get_order(){
		//$this->_save_return_uri();
		if($this->params->defined("order_no") && ($d = $this->form->validate($this->params))){
			$order = Order::FindFirst("order_no",$d["order_no"]);
			if(!$order){
				$this->form->set_error("order_no",_("Taková objednávka neexistuje"));
				return;
			}
			if(!OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason)){
				$this->form->set_error("order_no",$reason);
				return;
			}

			return [
				"order_id" => $order->getId(),
				// "return_uri" => $this->_get_return_uri(),
			];
		}
	}

	function create_new__send_otp(){
		$order = $this->_get_order();
		$this->tpl_data["order"] = $order;

		if($this->logged_user && $order->getUserId()===$this->logged_user->getId()){
			return $this->_next_step([
				"sent" => false,
			]);
		}

		if($this->request->post()){
			$code = (string)String4::RandomNumericString(8);
			$rec = OneTimePassword::CreateNewRecordFor("order_withdrawal",$order->getId(),$code,$order->getEmail());

			$this->mailer->notify_order_withdrawal_request_otp($order,$rec,$code);

			return [
				"sent" => true,
			];
		}
	}

	function create_new__authorize(){
		$order = $this->_get_order();
		$this->tpl_data["order"] = $order;

		if($this->logged_user && $order->getUserId()===$this->logged_user->getId()){
			return $this->_next_step([
				"authorized" => true,
			]);
		}

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			if(InvalidPasswordAttempt::IsRemoteAddressBlocked($this->request->getRemoteAddr(),$release_time,["purpose" => "order_withdrawal"])){
				$this->form->set_error(InvalidPasswordAttempt::BuildNextAttemptDelayMessage($release_time));
				return;
			}

			$code = $d["code"];
			$code = preg_replace('/\s/','',$code);
			if(!($otp = OneTimePassword::GetActiveInstanceFor("order_withdrawal",$order->getId(),$code))){
				InvalidPasswordAttempt::CreateNewRecord([
					"purpose" => "order_withdrawal",
					"object_key" => (string)$order->getId(),
				]);
				$this->form->set_error("code",_("Toto není platný kód"));
				return;
			}
			$otp->markAsUsed();
			return [
				"authorized" => true,
			];
		}
	}

	function create_new__get_data(){
		$order = $this->_get_order();
		$this->form->tune_for_order($order);

		$this->tpl_data["order"] = $order;

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$products = $d["products"];
			unset($d["products"]);
			$d["order_id"] = $order;
			$d["reasons"] = json_encode($d["reasons"]);

			// Objednavka musi byt porad vratitelna
			myAssert(OrderWithdrawalRequest::CanOrderBeWithdrawn($order));

			$ow = OrderWithdrawalRequest::CreateNewRecord($d);
			foreach($products as $product){
				$product = Cache::Get("Product",$product);
				$order_item = OrderItem::FindFirst("order_id",$order,"product_id",$product);
				$unit = $product->getUnit();
				OrderWithdrawalRequestItem::CreateNewRecord([
					"order_withdrawal_request_id" => $ow,
					"product_id" => $product,
					"amount" => $order_item->getAmount(),
				]);
			}

			$this->mailer->notify_order_withdrawal_request($ow);

			$this->_clear_walking_state();
			$this->_redirect_to("created");
		}
	}

	function created(){
		$this->_prepare_create_new_title();
	}

	function _get_order(){
		return Cache::Get("Order",$this->returned_by["get_order"]["order_id"]);
	}
}
