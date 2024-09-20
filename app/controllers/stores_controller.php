<?php
class StoresController extends ApplicationController {

	function index(){
		$this->page_title = _("List of stores");
		$this->breadcrumbs[] = _("Stores");
		$this->tpl_data["stores"] = Store::FindAll("visible",true);
		$this->head_tags->setCanonical($this->_build_canonical_url("stores/index"));
		$this->tpl_data["map_tiles_provider"] = MAP_TILES_PROVIDER;
		$this->tpl_data["map_tiles_api_key"] = MAP_TILES_API_KEY;
	}

	function detail(){
		if(!$this->store->isVisible()){
			return $this->_execute_action("error404");
		}
		$this->breadcrumbs[] = array(_("Stores"),"stores/index");
		$this->page_title = $this->breadcrumbs[] = $this->store->getName();
		$this->head_tags->setCanonical($this->_build_canonical_url(["action" => "stores/detail", "id" => $this->store]));
		$this->tpl_data["map_tiles_provider"] = MAP_TILES_PROVIDER;
		$this->tpl_data["map_tiles_api_key"] = MAP_TILES_API_KEY;

		$today = Date::Today();
		$monday = $today->getCurrentWeekMonday();

		// az 4 tydny dopredu se zobrazi mimoradne oteviraci hodiny
		$ids = $this->dbmole->selectIntoAssociativeArray("
			SELECT
				date AS key,
				id
			FROM
				special_opening_hours
			WHERE
				store_id=:store AND
				date>=:monday AND
				date<=:monday::DATE + INTERVAL '28 days'
			ORDER BY
				date
			",[
				":store" => $this->store,
				":monday" => $monday
			]
		);
		$special_opening_hours = $this->tpl_data["special_opening_hours"] = Cache::Get("SpecialOpeningHour",$ids);
	}

	function _before_filter(){
		if($this->action=="detail"){
			$this->_find("store");
		}
	}
}
