<?php
class CardCreatorsController extends AdminController {

	function create_new(){
		$card = $this->card;
		$this->_add_card_to_breadcrumbs($card);
		$this->_create_new(array(
			"page_title" => sprintf(_('Adding creator to the product "%s"'),$this->card->getName()),
			"create_closure" => function($d) use($card){
				$d["card_id"] = $card;
				return CardCreator::CreateNewRecord($d);
			}
		));
	}

	function edit(){
		$this->_add_card_to_breadcrumbs($this->card_creator->getCard());

		$this->_edit(array(
			"page_title" => _("Editing link between creator and product"),
		));
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
		if(in_array($this->action,array("edit"))){
			$this->_find("card_creator");
		}
	}
}
