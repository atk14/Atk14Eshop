<?php
class CustomerReviewHistory extends ApplicationModel {

	use TraitStatusHistoryItem;

	function getCustomerReviewChatPost(){
		return CustomerReviewChatPost::FindFirst("customer_review_id",$this->g("customer_review_id"),"customer_review_history_id",$this,["use_cache" => true]);
	}
}
