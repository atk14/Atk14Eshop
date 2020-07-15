<?php
class OrderItemsController extends AdminController {

	function create_new(){
		$order = $this->order;
		$this->_create_new([
			"page_title" => sprintf(_("Nová položka objednávky %s"),$order->getOrderNo()),
			"create_closure" => function($d) use($order){
				$product = $d["product_id"];
				$user = $order->getUser();
				$currency = $order->getCurrency();
				$price_finder = PriceFinder::GetInstance($user,$currency,$order->getCreatedAt());
				$product_price = $price_finder->getPrice($product,$d["amount"]);
				if(!$product_price){
					$this->form->set_error("product_id",_("Tento produkt nemá cenu"));
					return;
				}
				if(OrderItem::FindFirst("order_id",$order,"product_id",$product)){
					$this->form->set_error("product_id",_("Tento produkt už v objednávce je..."));
					return;
				}
				$d["order_id"] = $order;
				$d["vat_percent"] = $product->getVatPercent();
				$d["unit_price"] = $product_price->getUnitPrice();

				$item = OrderItem::CreateNewRecord($d);

				$order->recalculatePriceToPay();

				return $item;
			}
		]);
	}

	function edit(){
		$order = $this->order_item->getOrder();
		$this->form->fields["product_id"]->disabled = true;
		$this->form->fields["amount"]->label .= " [".$this->order_item->getProduct()->getUnit()."]";
		$this->_edit([
			"page_title" => sprintf(_("Editace položky objednávky %s"),$order->getOrderNo()),
			"update_closure" => function($item,$d) use($order){
				$ret = $item->s($d);
				$order->recalculatePriceToPay();
				return $ret;
			}
		]);
	}

	function destroy(){
		$order = $this->order_item->getOrder();
		$this->_destroy([
			"destroy_closure" => function($item) use($order){
				$item->destroy();
				$order->recalculatePriceToPay();
			}
		]);
	}

	function _before_filter(){
		$order = null;

		if(in_array($this->action,["create_new"])){
			$order = $this->_find("order","order_id");
		}

		if(in_array($this->action,["edit","destroy"])){
			($item = $this->_find("order_item")) && ($order = $item->getOrder());
		}

		$this->_add_order_to_breadcrumb($order);
	}
}
