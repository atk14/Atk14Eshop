<?php
/**
 * Recomputes also_bought_cards ("customers who bought this also bought")
 * from real order history.
 *
 * Co-purchases are detected across every order placed by the same customer, not just
 * within a single order - two orders belong to the same customer when they share a
 * user_id, or, for guest checkouts (user_id IS NULL), when they share the same email.
 *
 * It's a full, unconditional rescan every run (same philosophy as
 * FulltextIndexerRobot) rather than an incremental/dirty-flag update, since the
 * underlying order_items table is append-mostly and the aggregation is cheap
 * enough to run nightly.
 *
 * An order counts as a valid co-purchase source unless its status is explicitly
 * marked unsuccessful (finishing_unsuccessfully/finished_unsuccessfully) - fulfillment
 * here routinely stalls at "processing" and finishes in an external system that never
 * reports back, so requiring finishing_successfully/finished_successfully would starve
 * this of almost all real orders.
 */
class FrequentlyBoughtTogetherRobot extends ApplicationRobot {

	const MAX_RELATED_CARDS_PER_CARD = 12;

	// older orders stop contributing a co-purchase signal - keeps the data responsive
	// to what's currently selling rather than dragged down by years-old purchases
	const MAX_ORDER_AGE_DAYS = 365;

	function run(){
		if(!PRODUCT_RECOMMENDATIONS_ENABLED && !TEST){
			$this->logger->info("product recommendations is disabled, exiting...");
			return;
		}

		// Rewritten from an older version of this query that self-joined order_items/orders
		// directly via "o1.id=o2.id OR o1.user_id=o2.user_id OR o1.email=o2.email" - that OR
		// condition can't be turned into a hash/index join by the planner, so it was forcing
		// a near-full nested-loop/merge-join scan across order_items. Precomputing a single
		// customer_key per order (qualifying_items.customer_key below) turns "same customer"
		// into a plain equi-join. Filtering to visible/in-stock items happens once,
		// before the self-join, rather than against the full cross-joined pair set; and product
		// stockcount is summed once per product (product_stock) instead of once per output row.
		$rows = $this->dbmole->selectRows("
			WITH product_stock AS MATERIALIZED (
				SELECT wi.product_id, SUM(wi.stockcount) AS stockcount
				FROM warehouse_items wi
				JOIN warehouses w ON w.id=wi.warehouse_id AND w.applicable_to_eshop
				GROUP BY wi.product_id
			),
			qualifying_items AS MATERIALIZED (
				SELECT
					oi.order_id,
					oi.product_id,
					p.card_id,
					CASE
						WHEN o.user_id IS NOT NULL THEN 'u:' || o.user_id::text
						WHEN o.email IS NOT NULL THEN 'e:' || o.email
						ELSE 'o:' || o.id::text
					END AS customer_key
				FROM order_items oi
				JOIN orders o ON o.id=oi.order_id
				JOIN order_statuses os ON os.id=o.order_status_id
				JOIN products p ON p.id=oi.product_id
				JOIN cards c ON c.id=p.card_id
				WHERE
					oi.amount>0 AND
					o.created_at>=:since AND
					NOT os.finishing_unsuccessfully AND NOT os.finished_unsuccessfully AND
					c.visible AND NOT c.deleted AND
					(NOT p.consider_stockcount OR COALESCE((SELECT ps.stockcount FROM product_stock ps WHERE ps.product_id=p.id),0)>0)
			)
			SELECT
				qi1.card_id AS card_id,
				qi2.card_id AS related_card_id,
				COUNT(DISTINCT qi1.order_id) AS score
			FROM qualifying_items qi1
			JOIN qualifying_items qi2
				ON qi2.customer_key=qi1.customer_key
				AND qi2.product_id!=qi1.product_id
			WHERE qi1.card_id!=qi2.card_id
			GROUP BY qi1.card_id, qi2.card_id
			ORDER BY qi1.card_id, score DESC, qi2.card_id
		",array(
			":since" => date("Y-m-d H:i:s",strtotime("-".self::MAX_ORDER_AGE_DAYS." days")),
		));

		$by_card = array();
		foreach($rows as $row){
			$by_card[$row["card_id"]][] = $row;
		}

		$this->logger->info(sprintf("FrequentlyBoughtTogetherRobot: recomputed also-bought data for %d cards",sizeof($by_card)));

		$this->dbmole->doQuery("TRUNCATE also_bought_cards");

		foreach($by_card as $card_id => $card_rows){
			$rank = 0;
			foreach(array_slice($card_rows,0,self::MAX_RELATED_CARDS_PER_CARD) as $row){
				$this->dbmole->insertIntoTable("also_bought_cards",array(
					"card_id" => $card_id,
					"related_card_id" => $row["related_card_id"],
					"score" => $row["score"],
					"rank" => $rank++,
				));
			}
			$this->_commit();
		}
	}
}
