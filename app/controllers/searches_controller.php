<?php
class SearchesController extends ApplicationController {

	function index(){
		$this->page_title = $this->breadcrumbs[] = _("Vyhledávání");
		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$format = $this->params->getString("format"); // "snippet"

		if($format=="snippet"){
			$this->render_layout = false;
			$this->template_name = "snippet";
		}

		if(!strlen($d["q"])){
			return;
		}

		$this->page_title = sprintf(_('Vyhledávání: „%s“'),$d["q"]);

		$texmit = new \Textmit\Client();

		$options = array(
			"prefix_search" => true,
			//"type" => "article",
			//"meta_data" => "",
			"language" => $this->lang,
			"offset" => $this->params->getInt("offset"),
			"limit" => 20,
			//"damping_coefficient" => 10000000 // tlumi relevanci se starim datumu daneho dokumentu; cim vyssi cislo, tim mensi tlumeni; def. je 30
		);
		if($format=="snippet"){
			$options["offset"] = 0;
			$options["limit"] = 10;
		}

		$finder = $this->tpl_data["finder"] = $texmit->search($d["q"],$options);
		//print_r($finder);

		$objects = $finder->getRecords();
		$objects = array_filter($objects);
		$this->tpl_data["cards"] = $cards = array_values(array_filter($objects,function($object){ return is_a($object,"Card"); }));
		$this->tpl_data["categories"] = $categories = array_values(array_filter($objects,function($object){ return is_a($object,"Category"); }));
		$this->tpl_data["others"] = $others = array_values(array_filter($objects,function($object){ return !is_a($object,"Card") && !is_a($object,"Category"); }));
		$objects = [];
		foreach([$cards,$categories,$others] as $ary){
			foreach($ary as $o){ $objects[] = $o; }
		}
		$this->tpl_data["objects"] = $objects;

		if($finder->isEmpty()){
			$this->head_tags->setMetaTag("robots", "noindex,noarchive");
			$this->head_tags->setMetaTag("googlebot", "noindex");
		}
	}

	function _before_filter(){
		// Caching result for 1 character for 1 hour
		if(PRODUCTION && $this->action==="index" && $this->request->xhr() && $this->params->getString("format")==="snippet" && strlen(trim($this->params->getString("q")))==1){
			$this->_caches_action([
				"salt" => mb_strtolower(trim($this->params->getString("q"))),
				"expires" => 60 * 60, // 1h
			]);
		}
	}
}
