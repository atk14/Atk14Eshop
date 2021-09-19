<?php
class CampaignsController extends AdminController {

	function index(){
		$this->page_title = _("Kampaně");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];

		if($d["search"]){
			$ar = [
				"id::VARCHAR",
				"discount_percent::VARCHAR",
				"(SELECT body FROM translations WHERE record_id=campaigns.id AND table_name='campaigns' AND key='name' AND lang=:lang)",
				"regions::VARCHAR",
			];
			$fields = "UPPER(COALESCE(".join(",'')||' '||COALESCE(",$ar).",''))";
			if($conds = FullTextSearchQueryLike::GetQuery($fields,Translate::Upper($d["search"]),$bind_ar)){
				$bind_ar[":search"] = $d["search"];
				$conditions[] = $conds;
			}
		}

		$this->sorting->add("created_at",["reverse" => true]);
		$this->sorting->add("name","UPPER(COALESCE((SELECT body FROM translations WHERE record_id=campaigns.id AND table_name='campaigns' AND key='name' AND lang=:lang),''))");

		$bind_ar[":lang"] = $this->lang;

		$this->tpl_data["finder"] = Campaign::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
			"offset" => $this->params->getInt("offset"),
		]);
	}

	function create_new(){
		$this->_create_new([
			"page_title" => _("Nová kampaň"),
			"create_closure" => function($d){
				$designated_for_tags = $d["designated_for_tags"];
				unset($d["designated_for_tags"]);
				$excluded_for_tags = $d["excluded_for_tags"];
				unset($d["excluded_for_tags"]);
				$campaign = Campaign::CreateNewRecord($d);
				$campaign->getDesignatedForTagsLister()->setRecords($designated_for_tags);
				$campaign->getExcludedForTagsLister()->setRecords($excluded_for_tags);
				return $campaign;
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace kampaně"),
			"set_initial_closure" => function($form,$campaign){
				$form->set_initial($campaign);
				$form->set_initial("designated_for_tags",$campaign->getDesignatedForTags());
				$form->set_initial("excluded_for_tags",$campaign->getExcludedForTags());
			},
			"update_closure" => function($campaign,$d){
				$designated_for_tags = $d["designated_for_tags"];
				unset($d["designated_for_tags"]);
				$excluded_for_tags = $d["excluded_for_tags"];
				unset($d["excluded_for_tags"]);
				$campaign->s($d);
				$campaign->getDesignatedForTagsLister()->setRecords($designated_for_tags);
				$campaign->getExcludedForTagsLister()->setRecords($excluded_for_tags);
				return $campaign;
			}
		]);
	}

	function destroy(){
		$this->_destroy();
	}
}
