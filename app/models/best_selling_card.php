<?php
/**
 * Precomputed global "best selling" ranking (see robots/best_selling_cards_robot.php).
 * Used by SellingAdvisor as the final fallback when there's no other signal at all.
 *
 * The whole table is truncated and rewritten by the robot on every run, so there's
 * no notion of manually reordering individual rows - reads are just sorted by score.
 */
class BestSellingCard extends ApplicationModel {

	function getCard() {
		return Cache::Get("Card", $this->getCardId());
	}

	/**
	 * @return Card[] ordered best first
	 */
	static function GetCards() {
		$cards = array();
		foreach (self::FindAll(array("order_by" => "score DESC")) as $best_selling_card) {
			$cards[] = $best_selling_card->getCard();
		}
		return $cards;
	}
}
