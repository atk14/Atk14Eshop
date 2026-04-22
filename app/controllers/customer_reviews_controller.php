<?php
class CustomerReviewsController extends ApplicationController {

	// List of user reviews of the logged-in user
	function index(){
		if(!$this->logged_user){
			return $this->_execute_action("error403");
		}

		$this->_add_user_detail_breadcrumb();
		$this->page_title = $this->breadcrumbs[] = _("My reviews");
	
		$this->tpl_data["review_candidates"] = ProductCustomerReviewCandidate::GetInstancesByUser($this->logged_user);
		$this->tpl_data["reviews"] = CustomerReview::FindAll([
			"conditions" => [
				"user_id=:user",
				"customer_review_status_id IN (SELECT id FROM customer_review_statuses WHERE NOT finished_unsuccessfully)",
			],
			"bind_ar" => [
				":user" => $this->logged_user,
			],
			"order_by" => "created_at DESC, id DESC"
		]);
	}

	function create_new(){
		if($this->logged_user){
			$this->_add_user_detail_breadcrumb();
			$this->breadcrumbs[] = [_("My reviews"),$this->_link_to("index")];
		}

		$this->head_tags->setMetaTag("robots", "noindex,noarchive");
		$this->head_tags->setMetaTag("googlebot", "noindex");

		$this->_walk([
			"get_product",
			"set_rating",
			"write_review",
		]);
	}
	
	function create_new__get_product(){
		$order_item = null;
		$card = null;
		$product = null;

		if($this->params->defined("order_item_token")){
			$order_item = OrderItem::GetInstanceByToken($this->params->getString("order_item_token"),"customer_review_salt");
			if(!$order_item){
				$this->_execute_action("error404");
				return;
			}
			$product = $order_item->getProduct();

		}elseif($this->params->defined("card_id")){
			$card = Card::GetInstanceById($this->params->getInt("card_id"));
			if(!$card){
				$this->_execute_action("error404");
				return;
			}
			$product = $card->getFirstProduct();

		}else{
			$product = Product::GetInstanceById($this->params->getInt("product_id"));
			if(!$product){
				$this->_execute_action("error404");
				return;
			}
		}

		if(!$order_item && !CustomerReview::CanUserReviewProduct($this->logged_user,$product)){
			if(!$this->logged_user){
				$this->_add_card_to_breadcrumbs($product->getCard());
			}
			$this->page_title = $this->breadcrumbs[] = CustomerReview::PrepareTitleForProduct($product);
			$this->tpl_data["modal_title"] = CustomerReview::PrepareTitleForProduct($product);
			$this->tpl_data["product"] = $product;
			$this->template_name = "create_new/product_cant_be_reviewed";
			return;
		}

		return $this->_next_step([
			"product_id" => $product->getId(),
			"order_item_id" => ($order_item ? $order_item->getId() : null),
			"return_uri" => $this->_get_return_uri(),
		]);
	}

	function create_new__set_rating(){
		list($product,$order_item) = $this->_get_product_and_order_item();

		$this->form->tune_for_product($product);

		$modal_title = CustomerReview::PrepareTitleForProduct($product);
		$this->page_title = $this->breadcrumbs[] = sprintf("$modal_title - %s",$product->getName());
		$this->tpl_data["modal_title"] = $modal_title;

		$existing_cr = $order_item ? CustomerReview::FindFirst("order_id",$order_item->getOrder(),"product_id",$product_id) : CustomerReview::FindFirst("user_id",$this->logged_user,"product_id",$product);

		$this->form->set_initial([
			"rating" => $existing_cr ? $existing_cr->getRating() : null,
		]);

		if($this->request->post() && $this->params->defined("rating_submitted") && ($d = $this->form->validate($this->params))){
			if($existing_cr){
				$existing_cr->s("rating",$d["rating"]);
			}else{
				CustomerReview::CreateNewRecord([
					"product_id" => $product,
					"order_id" => $order_item,
					"user_id" => $order_item ? null : $this->logged_user,
					"language" => $this->lang,
					"rating" => $d["rating"],
				]);
			}

			if(!$this->request->xhr()){
				return true;
			}

			$this->_next_step(true);
		}

		$this->tpl_data["product"] = $product;
	}

	function create_new__write_review(){
		list($product,$order_item) = $this->_get_product_and_order_item();

		$this->form->tune_for_product($product);

		$this->page_title = $this->breadcrumbs[] = CustomerReview::PrepareTitleForProduct($product,["type" => "write_review_for"]);

		$existing_cr = $order_item ? CustomerReview::FindFirst("order_id",$order_item->getOrder(),"product_id",$product_id) : CustomerReview::FindFirst("user_id",$this->logged_user,"product_id",$product);
		myAssert($existing_cr);

		$initial = $existing_cr->toArray();
		if(!strlen((string)$initial["author"]) && $this->logged_user){ $initial["author"] = $this->logged_user->getFirstname(); }
		if(!strlen((string)$initial["title"])){
			$tr = [
				"1" => _("Poor"),
				"2" => _("Fair"),
				"3" => _("Good"),
				"4" => _("Very good"),
				"5" => _("Excellent"),
			];
			$initial["title"] = $tr[$existing_cr->getRating()];
		}

		$this->form->set_initial($initial);

		if($this->request->post() && $this->params->defined("review_submitted") && ($d = $this->form->validate($this->params))){
			$existing_cr->s($d);

			$this->flash->success(_("Your review has been saved. Thank You."));
			$this->_redirect_to($this->returned_by["get_product"]["return_uri"]);
			//return true;
		}

		$this->tpl_data["product"] = $product;
	}

	function destroy(){
		$customer_review = $this->_find("customer_review");
		if(!$customer_review || $customer_review->getUserId()!==$this->logged_user->getId()){
			return $this->_execute_action("error404");
		}

		$customer_review->destroy();

		if(!$this->request->xhr()){
			$this->_redirect_to("index");
		}
	}

	function _get_product_and_order_item(){
		$product = Cache::Get("Product",$this->returned_by["get_product"]["product_id"]);
		$order_item = Cache::Get("OrderItem",$this->returned_by["get_product"]["order_item_id"]);
		return [$product,$order_item];
	}

	function _before_filter(){
		if(!CUSTOMER_REVIEWS_ENABLED){
			return $this->_execute_action("error404");
		}
		if(in_array($this->action,["destroy"]) && !$this->logged_user){
			return $this->_execute_action("error404");
		}
	}
}
