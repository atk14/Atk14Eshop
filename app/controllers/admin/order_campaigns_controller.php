<?php
class OrderCampaignsController extends AdminController {

	function create_new(){
		$order = $this->order;
		$this->_create_new([
			"page_title" => _("Nová kampaň objednávky"),
			"create_closure" => function($d) use($order){
				if(OrderCampaign::FindFirst("order_id",$order,"campaign_id",$d["campaign_id"])){
					$this->form->set_error("campaign_id",_("Tuto kampaň již objednávka obsahuje"));
					return;
				}

				$d["order_id"] = $order;
				$d["created_administratively"] = true;
				$ret = OrderCampaign::CreateNewRecord($d);
				$order->recalculatePriceToPay();
				return $ret;
			}
		]);	
	}

	function edit(){
		$order = $this->order;
		$this->_edit([
			"page_title" => _("Editace kampaně u objednávky"),
			"update_closure" => function($order_campaign,$d) use($order){
				$ret = $order_campaign->s($d);
				$order->recalculatePriceToPay();
				return $ret;
			}
		]);
	}

	function destroy(){
		$order = $this->order;
		$this->_destroy([
			"destroy_closure" => function($order_campaign) use($order){
				$order_campaign->destroy();
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
			($order_campaign = $this->_find("order_campaign")) && ($order = $order_campaign->getOrder());
		}

		$this->order = $order;

		$this->_add_order_to_breadcrumb($order);
	}
}
