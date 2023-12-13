<?php
class CreatorCardsController extends ApplicationController {

	function index(){
		if(!$this->rendering_component){
			// This action is meant to be used in rendering component mode on the given creator's profile page
			return $this->_execute_action("error404");
		}

		$creators = Creator::FindAll("page_id",$this->page);

		if(!$creators){
			$this->render_template = false;
			return;
		}

		$ids = $this->dbmole->selectIntoArray("
			SELECT
				card_creators.id
			FROM
				card_creators,
				creator_roles,
				cards
			WHERE
				card_creators.creator_id IN :creators AND
				creator_roles.id=card_creators.creator_role_id AND
				cards.id=card_creators.card_id AND
				cards.visible AND
				NOT cards.deleted
			ORDER BY
				creator_roles.rank,
				creator_roles.id,	
				cards.created_at DESC
		",[":creators" => $creators]);

		$card_creators = Cache::Get("CardCreator",$ids);

		$items = [];
		foreach($card_creators as $cc){
			$role = $cc->getRole();
			$role_id = $role->getId();
			if(!isset($items[$role_id])){
				$items[$role_id] = [
					"creator_role" => $role,
					"cards" => [],
				];
			}
			$items[$role_id]["cards"][] = $cc->getCard();
		}

		$this->tpl_data["items"] = $items;
	}

	function _before_filter(){
		$this->_find("page","page_id");
	}
}
