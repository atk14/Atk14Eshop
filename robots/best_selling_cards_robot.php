<?php
/**
 * Recomputes best_selling_cards - a simple global "what sells the most" ranking,
 * used by SellingAdvisor as the last-resort fallback when there's no card, category,
 * basket or viewed-cards signal to build recommendations from at all.
 *
 * Order counts are collected over several periods (year/month/week/day) rather than
 * one fixed window, so a brand new hit selling well only over the last day or two can
 * still surface - a single year-long window would drown it out under established
 * products' accumulated sales.
 *
 * Full, unconditional rescan every run, same philosophy as FrequentlyBoughtTogetherRobot.
 *
 * An order counts as a sale unless its status is explicitly marked unsuccessful
 * (finishing_unsuccessfully/finished_unsuccessfully) - fulfillment here routinely stalls
 * at "processing" and finishes in an external system that never reports back, so
 * requiring finishing_successfully/finished_successfully would starve this of almost
 * all real orders (see FrequentlyBoughtTogetherRobot).
 */
class BestSellingCardsRobot extends ApplicationRobot {

	const MAX_CARDS = 50;

	const WINDOW_YEAR_DAYS = 365;
	const WINDOW_MONTH_DAYS = 30;
	const WINDOW_WEEK_DAYS = 7;
	const WINDOW_DAY_DAYS = 1;

	function run(){
		$rows = $this->dbmole->selectRows("
			SELECT
				p.card_id AS card_id,
				COALESCE(SUM(oi.amount) FILTER (WHERE o.created_at>=:since_year),0) AS score_last_year,
				COALESCE(SUM(oi.amount) FILTER (WHERE o.created_at>=:since_month),0) AS score_last_month,
				COALESCE(SUM(oi.amount) FILTER (WHERE o.created_at>=:since_week),0) AS score_last_week,
				COALESCE(SUM(oi.amount) FILTER (WHERE o.created_at>=:since_day),0) AS score_last_day
			FROM
				order_items oi,
				orders o,
				order_statuses os,
				products p,
				cards c
			WHERE
				oi.amount>0 AND
				o.id=oi.order_id AND
				o.created_at>=:since_year AND
				os.id=o.order_status_id AND
				NOT os.finishing_unsuccessfully AND NOT os.finished_unsuccessfully AND
				p.id=oi.product_id AND
				c.id=p.card_id AND c.visible AND NOT c.deleted AND
				(NOT p.consider_stockcount OR (SELECT COALESCE(SUM(warehouse_items.stockcount),0) FROM warehouse_items,warehouses WHERE warehouses.applicable_to_eshop AND warehouse_items.warehouse_id=warehouses.id AND warehouse_items.product_id=p.id)>0)
			GROUP BY p.card_id
		",array(
			":since_year" => date("Y-m-d H:i:s",strtotime("-".self::WINDOW_YEAR_DAYS." days")),
			":since_month" => date("Y-m-d H:i:s",strtotime("-".self::WINDOW_MONTH_DAYS." days")),
			":since_week" => date("Y-m-d H:i:s",strtotime("-".self::WINDOW_WEEK_DAYS." days")),
			":since_day" => date("Y-m-d H:i:s",strtotime("-".self::WINDOW_DAY_DAYS." days")),
		));

		// each period's count is normalized to a per-day rate before being summed, so a
		// burst of sales in the last day/week weighs in on equal footing with the same
		// rate of sales sustained over the whole month/year - no arbitrary weight tuning
		foreach($rows as &$row){
			$row["score"] =
				$row["score_last_year"]/self::WINDOW_YEAR_DAYS +
				$row["score_last_month"]/self::WINDOW_MONTH_DAYS +
				$row["score_last_week"]/self::WINDOW_WEEK_DAYS +
				$row["score_last_day"]/self::WINDOW_DAY_DAYS;
		}
		unset($row);

		usort($rows,function($a,$b){ return $b["score"] <=> $a["score"]; });
		$rows = array_slice($rows,0,self::MAX_CARDS);

		$this->logger->info(sprintf("BestSellingCardsRobot: recomputed best-selling ranking for %d cards",sizeof($rows)));

		$this->dbmole->doQuery("TRUNCATE best_selling_cards");

		foreach($rows as $row){
			$this->dbmole->insertIntoTable("best_selling_cards",array(
				"card_id" => $row["card_id"],
				"score_last_year" => $row["score_last_year"],
				"score_last_month" => $row["score_last_month"],
				"score_last_week" => $row["score_last_week"],
				"score_last_day" => $row["score_last_day"],
				"score" => $row["score"],
			));
		}
	}
}
