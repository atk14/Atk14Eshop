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
			"page_title" => _("Nová kampaň")
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace kampaně")
		]);
	}

	function destroy(){
		$this->_destroy();
	}
}
