<?php
class SearchesController extends ApplicationController {

	function index(){
		$this->page_title = $this->breadcrumbs[] = _("Vyhledávání");
		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		if(!strlen($d["q"])){
			return;
		}

		$this->page_title = sprintf(_('Vyhledávání: „%s“'),$d["q"]);
		$texmit = new \Textmit\Client();
		$finder = $this->tpl_data["finder"] = $texmit->search($d["q"],array(
			//"type" => "article",
			//"meta_data" => "",
			"language" => $this->lang,
			"offset" => $this->params->getInt("offset"),
			"limit" => 20,
			//"damping_coefficient" => 10000000 // tlumi relevanci se starim datumu daneho dokumentu; cim vyssi cislo, tim mensi tlumeni; def. je 30
		));
		//print_r($finder);
	}
}
