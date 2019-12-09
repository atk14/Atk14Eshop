<?php
class CardCreator extends ApplicationModel implements Rankable {

	function setRank($new_rank){
		$this->_setRank($new_rank,array(
			"card_id" => $this->g("card_id")
		));
	}

	function isMainCreator(){ return $this->g("is_main_creator"); }

}
