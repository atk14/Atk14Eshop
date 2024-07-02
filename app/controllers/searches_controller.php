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

		$q = String4::ToObject($d["q"])->trim()->gsub('/\s+/',' ');

		if(!$q->length()){
			return;
		}

		$offset = $this->params->getInt("offset");
		if(!is_null($offset) && $offset<0){
			$params = $this->params->toArray();
		 	unset($params["offset"]);
			$this->_redirect_to($params);
			return;
		}

		$this->page_title = sprintf(_('Vyhledávání: „%s“'),$q);

		$texmit = new \Textmit\Client();

		$options = array(
			"prefix_search" => $q->length()>2, // prefix_search is slow for short strings
			//"type" => "article",
			//"meta_data" => "",
			"language" => $this->lang,
			"offset" => $offset,
			"limit" => 20,
			//"damping_coefficient" => 10000000 // tlumi relevanci se starim datumu daneho dokumentu; cim vyssi cislo, tim mensi tlumeni; def. je 30
			"boosted_types" => "card", // in sorting, cards should be priritized over other other document types
		);
		if($format=="snippet"){
			$options["offset"] = 0;
			$options["limit"] = 10;
		}

		$finder = $this->tpl_data["finder"] = $texmit->search($q->toString(),$options);

		if(!is_null($offset) && $offset>=$finder->getTotalAmount()){
			$params = $this->params->toArray();
		 	unset($params["offset"]);
			$this->_redirect_to($params);
			return;
		}

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

		if(DEVELOPMENT && class_exists("Tracy\Debugger")){
			$bar = Tracy\Debugger::getBar();
			$bar->addPanel(new ApiDataFetcherPanel($texmit->getApiDataFetcher(),["title" => "Textmit"]));
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
