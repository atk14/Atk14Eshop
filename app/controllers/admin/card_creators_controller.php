<?php
class CardCreatorsController extends AdminController {

	function create_new(){
		$card = $this->card;
		$this->_create_new(array(
			"create_closure" => function($d) use($card){
				$d["card_id"] = $card;
				return CardCreator::CreateNewRecord($d);
			}
		));
	}

	function edit(){
		$this->_edit();
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(in_array($this->action,array("create_new"))){
			$this->_find("card","card_id");
		}
	}
}
