<?php
class CardCustomerReviewsController extends ApplicationController {

	function index(){
		$card = $this->card;

		$rating = CustomerReview::GetRatingFor($card,$review_count);

		$this->_add_card_to_breadcrumbs($card);
		$this->breadcrumbs[] = _("Rating");

		$modal_title = CustomerReview::PrepareTitleForProduct($card);
		$this->page_title = sprintf("$modal_title - %s",$card->getName());
		$this->tpl_data["modal_title"] = $modal_title;

		$starts = [];
		$products = $card->getProducts();

		$this->tpl_data["rating"] = $rating;
		$this->tpl_data["review_count"] = $review_count;
		$this->tpl_data["customer_reviews"] = CustomerReview::GetPublishedReviewsByCard($card);
		$this->tpl_data["star_rows"] = CustomerReview::GetStarRowsFor($card);

		//if(is_null($rating)){
			$this->head_tags->setMetaTag("robots", "noindex,noarchive");
			$this->head_tags->setMetaTag("googlebot", "noindex");
		//}
	}

	function _before_filter(){
		if(!CUSTOMER_REVIEWS_ENABLED){
			$this->_execute_action("error404");
			return;
		}
		$this->_find("card","card_id");
	}
}
