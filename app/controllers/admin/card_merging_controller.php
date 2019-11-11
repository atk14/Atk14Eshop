<?php
class CardMergingController extends AdminController {

	function create_new(){
		$this->page_title = _("Spojování produktů");
		$this->_walk(array(
			"get_cards",
			"get_labels",
			"merge",
		));
	}

	function create_new__get_cards(){
		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$cards = [];
			for($i=1;$i<=$this->form->count_of_cards;$i++){
				if(!isset($d["card_$i"])){ continue; }
				$cards[] = $d["card_$i"];
			}
			return $cards;
		}
	}

	function create_new__get_labels(){
		$this->form->prepare_for_cards($this->returned_by["get_cards"]);

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$labels = [];
			foreach($d as $key => $label){
				if(!preg_match('/^product_(\d+)_(.+)$/',$key,$matches)){ continue; }
				$id = $matches[1];
				$lang = $matches[2];
				if(!isset($labels[$id])){ $labels[$id] = []; }
				$labels[$id]["label_$lang"] = $label;
			}
			return $labels;
		}
	}

	function create_new__merge(){
		$cards = $this->returned_by["get_cards"];
		$labels = $this->returned_by["get_labels"];
		$primary_card = $cards[0];

		$primary_card->s("has_variants",true);
		$rank = 1;
		foreach($cards as $card){
			$products = Product::FindAll("card_id",$card);
			foreach($products as $product){
				$p_id = $product->getId();
				if(isset($labels[$p_id])){
					$product->s($labels[$p_id]);
				}
				$product->s([
					"card_id" => $primary_card,
					"rank" => $rank,
				]);
				$rank++;
			}
			if($card->getId()!=$primary_card->getId()){
				myAssert(sizeof($card->getProducts(["deleted" => null, "visible" => null]))==0);
				$card->destroy(true);
			}
		}

		$this->flash->success(_("Products were successfully merged"));
		$this->_redirect_to([
			"action" => "cards/edit",
			"id" => $primary_card->getId(),
		]);
	}
}
