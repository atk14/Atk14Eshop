<?php
/**
 * Admin-managed, global list of cards that should be preferred whenever they turn
 * up as a candidate in SellingAdvisor's recommendations ("customers who bought
 * this also bought"). See that class for how the boost is actually applied.
 */
class CardRecommendationBoost extends ApplicationModel implements Rankable {

	function getCard() {
		return Cache::Get("Card", $this->getCardId());
	}

	function setRank($new_rank) {
		return $this->_setRank($new_rank);
	}

	/**
	 * @return array card_id => true, for a fast candidate lookup
	 */
	static function GetBoostedCardIds() {
		$out = array();
		foreach (self::FindAll() as $boost) {
			$out[$boost->getCardId()] = true;
		}
		return $out;
	}
}
