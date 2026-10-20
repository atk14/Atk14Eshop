<?php
/**
 * Admin management of the global "preferred in recommendations" card list.
 *
 * See CardRecommendationBoost / SellingAdvisor.
 */
class CardRecommendationBoostsController extends AdminController {

	function index() {
		$this->page_title = _("Preferred products in recommendations");
		$this->tpl_data["card_recommendation_boosts"] = CardRecommendationBoost::FindAll();
	}

	function create_new() {
		$this->_create_new(array(
			"page_title" => _("Add a preferred product"),
			"flash_message" => _("The product has been added"),
			"create_closure" => function ($d) {
				if($boost = CardRecommendationBoost::FindFirst("card_id", $d["card_id"])){
					$boost->s(array("negative" => $d["negative"]));
				}else{
					$boost = CardRecommendationBoost::CreateNewRecord($d);
				}
				$boost->setRank(0);
				return $boost;
			},
		));
	}

	function edit(){
		$this->_edit();
	}

	function set_rank() {
		$this->_set_rank();
	}

	function destroy() {
		$this->_destroy();
	}

	function _redirect_back($default = null) {
		if (is_null($default)) {
			$default = array("controller" => "card_recommendation_boosts", "action" => "index");
		}
		return parent::_redirect_back($default);
	}
}
