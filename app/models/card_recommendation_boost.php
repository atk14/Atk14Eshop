<?php
/**
 * Admin-managed, global list of cards that should be preferred - or, when flagged
 * "negative", actively suppressed - whenever they turn up as a candidate in
 * SellingAdvisor's recommendations ("customers who bought this also bought").
 * See that class for how the adjustment is actually applied.
 */
class CardRecommendationBoost extends ApplicationModel implements Rankable {

	const SCORE_ADJUSTMENT = 1000;

	function getCard() {
		return Cache::Get("Card", $this->getCardId());
	}

	function isNegative() {
		return $this->getNegative();
	}

	function setRank($new_rank) {
		return $this->_setRank($new_rank);
	}

	/**
	 * @return array card_id => signed score adjustment to apply (positive for a
	 *   regular boost, negative to suppress), for a fast candidate lookup
	 */
	static function GetScoreAdjustments() {
		$out = array();
		foreach (self::FindAll() as $boost) {
			$out[$boost->getCardId()] = $boost->isNegative() ? -self::SCORE_ADJUSTMENT : self::SCORE_ADJUSTMENT;
		}
		return $out;
	}
}
