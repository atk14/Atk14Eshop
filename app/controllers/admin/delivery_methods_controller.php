<?php
class DeliveryMethodsController extends AdminController {

	function index() {
		$this->page_title = _("Způsoby dopravy");
		$this->tpl_data["delivery_methods"] = DeliveryMethod::FindAll();
	}

	function create_new() {
		$this->_create_new(array(
			"page_title" => _("Vytvořit nový způsob dopravy"),
			"create_closure" => function($d){
				$designated_for_tags = $d["designated_for_tags"];
				unset($d["designated_for_tags"]);
				$excluded_for_tags = $d["excluded_for_tags"];
				unset($d["excluded_for_tags"]);
				$dm = DeliveryMethod::CreateNewRecord($d);
				$dm->getDesignatedForTagsLister()->setRecords($designated_for_tags);
				$dm->getExcludedForTagsLister()->setRecords($excluded_for_tags);
				return $dm;
			}
		));
	}

	function edit() {
		$this->tpl_data["countries"] = Region::GetDeliveryCountriesFromAllRegions();

		$this->_edit([
			"page_title" => _("Editace způsobu dopravy"),
			"set_initial_closure" => function($form,$dm){
				$form->set_initial($dm);
				$form->set_initial("designated_for_tags",$dm->getDesignatedForTags());
				$form->set_initial("excluded_for_tags",$dm->getExcludedForTags());
			},
			"update_closure" => function($dm,$d){
				$designated_for_tags = $d["designated_for_tags"];
				unset($d["designated_for_tags"]);
				$excluded_for_tags = $d["excluded_for_tags"];
				unset($d["excluded_for_tags"]);
				$dm->s($d);
				$dm->getDesignatedForTagsLister()->setRecords($designated_for_tags);
				$dm->getExcludedForTagsLister()->setRecords($excluded_for_tags);
				return $dm;
			}
		]);
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter() {
		if (in_array($this->action, array("edit", "enable", "disable", "set_rank", "destroy"))) {
			$this->_find("delivery_method");
		}
	}
}
