<?php
class CustomerReviewsForm extends ApplicationForm {

	function tune_for_product($product){
		if(isset($this->fields["rating"])){
			$this->fields["rating"]->label = CustomerReview::PrepareTitleForProduct($product,"how_do_you_like");
		}
	}
}
