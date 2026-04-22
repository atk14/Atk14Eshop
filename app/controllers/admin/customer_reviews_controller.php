<?php
class CustomerReviewsController extends AdminController {

	function index(){
		$this->page_title = _("Customer reviews");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];

		if($d["search"]){
			$_fields = [
				"id",
				"author",
				"title",
				"body",
				"(SELECT catalog_id FROM products WHERE id=customer_reviews.product_id)",
				"(SELECT body FROM translations WHERE table_name='cards' AND key='name' AND record_id=(SELECT card_id FROM products WHERE id=customer_reviews.product_id) AND lang=:lang)",
			];
			if($ft_cond = FullTextSearchQueryLike::GetQuery("UPPER(".join("||' '||",$_fields).")",Translate::Upper($d["search"]),$bind_ar)){
				$conditions[] = $ft_cond;
				$bind_ar[":lang"] = $this->lang;
			}
		}

		if($d["customer_review_status_id"]){
			$conditions[] = "customer_review_status_id=:customer_review_status";
			$bind_ar[":customer_review_status"] = $d["customer_review_status_id"];
		}

		$this->sorting->add("created_at","created_at DESC, id DESC");
		
		$this->tpl_data["finder"] = CustomerReview::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"offset" => $this->params->getInt("offset"),
			"order_by" => $this->sorting,
		]);
	}

	function edit(){
		$logged_user = $this->logged_user;
		$this->_edit([
			"update_closure" => function($customer_review,$d) use($logged_user){
				$customer_review_status = $d["customer_review_status_id"];
				unset($d["customer_review_status_id"]);

				$customer_review->s($d);

				if($customer_review->getCustomerReviewStatusId()!==$customer_review_status->getId()){
					$customer_review->setNewStatus([
						"customer_review_status_id" => $customer_review_status,
						"customer_review_status_set_by_user_id" => $logged_user,
					]);
				}

				return $customer_review_status;
			}
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(!CUSTOMER_REVIEWS_ENABLED){
			return $this->_execute_action("error404");
		}

		if(in_array($this->action,["detail"])){
			$this->_find("customer_review");
		}
	}
}
