<?php
class OrderOrderStatusesController extends AdminController {

	function create_new() {
		$this->_walk([
			"get_order",
			"get_order_status",
			"get_data",
			"update_status",
		]);
	}

	function _before_walking(){
		if(isset($this->returned_by["get_order"])){
			$order = $this->order = $this->tpl_data["order"] = Cache::Get("Order",$this->returned_by["get_order"]["order_id"]);
			if(!$order){
				return $this->_execute_action("error404");
			}
			if($order->getOrderStatusId()!==$this->returned_by["get_order"]["order_status_id"]){
				return $this->_execute_action("error404");
			}
			if(!$order->getAllowedNextOrderStatuses()){
				return $this->_execute_action("error404");
			}
			$_label = sprintf(_("Objednávka %d"), $this->order->getOrderNo());
			$this->breadcrumbs[] = array($_label, $this->_link_to(["action" => "orders/detail", "id" => $this->order]));
			$this->page_title = sprintf(_("Změna stavu objednávky %s"), $this->order->getOrderNo());
		}
	}

	function create_new__get_order(){
		if(!$order = Order::GetInstanceById($this->params->getInt("order_id"))){
			return $this->_execute_action("error404");
		}
		return $this->_next_step([
			"order_id" => $order->getId(),
			"order_status_id" => $order->getOrderStatusId(),
			"return_uri" => $this->_get_return_uri(),
		]);
	}

	function create_new__get_order_status(){
		$this->form->prepare_for_order($this->order);
		$this->form->set_initial($this->params);

		if ($this->request->post() && ($d=$this->form->validate($this->params))) {
			return $d;
			$new_status_values = array(
				"order_status_id" => $d["order_status"],
				"order_status_set_by_user_id" => $this->logged_user,
				"order_status_note" => $d["order_status_note"],
			);
			$this->order->setNewOrderStatus($new_status_values);
			if (!$this->request->xhr()) {
				return $this->_redirect_to(array("controller" => "orders", "action" => "detail", "id" => $this->order));
			}
		}
	}

	function create_new__get_data(){
		$current_order_status = $this->order->getOrderStatus();
		$new_order_status = $this->tpl_data["new_order_status"] = $this->returned_by["get_order_status"]["order_status"];

		if($new_order_status->getCode()=="payment_accepted"){
			$this->form->add_price_paid_field($this->order);
		}

		if($new_order_status->getCode()=="shipped"){
			$this->form->add_tracking_number($this->order);
		}

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			return $d;
		}
	}

	function create_new__update_status(){
		$d = $this->form_data["get_data"];

		foreach([
			"price_paid",
			"tracking_number",
		] as $field){
			if(array_key_exists($field,$d)){
				$this->order->s($field,$d[$field]);
			}
		}

		$new_status_values = array(
			"order_status_id" => $this->form_data["get_order_status"]["order_status"],
			"order_status_set_by_user_id" => $this->logged_user,
			"order_status_note" => $d["order_status_note"],
		);
		$this->order->setNewOrderStatus($new_status_values);

		$this->flash->success(_("Byl nastaven úspěšně nový stav objednávky"));
		$this->_redirect_to($this->returned_by["get_order"]["return_uri"]);
	}
}
