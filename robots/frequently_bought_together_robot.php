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
		$rows = $this->dbmole->selectRows("
			SELECT
				pa.card_id AS card_id,
				pb.card_id AS related_card_id,
				COUNT(DISTINCT oi1.order_id) AS score
			FROM
				order_items oi1,
				order_items oi2,
				orders o1,
				orders o2,
				order_statuses os1,
				order_statuses os2,
				products pa,
				products pb,
				cards ca,
				cards cb
			WHERE
				oi1.product_id!=oi2.product_id AND
				oi1.amount>0 AND oi2.amount>0 AND
				o1.id=oi1.order_id AND
				o2.id=oi2.order_id AND
				o1.created_at>=:since AND
				o2.created_at>=:since AND
				os1.id=o1.order_status_id AND NOT os1.finishing_unsuccessfully AND NOT os1.finished_unsuccessfully AND
				os2.id=o2.order_status_id AND NOT os2.finishing_unsuccessfully AND NOT os2.finished_unsuccessfully AND
				(
					o1.id=o2.id OR
					(o1.user_id IS NOT NULL AND o1.user_id=o2.user_id) OR
					(o1.user_id IS NULL AND o2.user_id IS NULL AND o1.email IS NOT NULL AND o1.email=o2.email)
				) AND
				pa.id=oi1.product_id AND
				pb.id=oi2.product_id AND
				pa.card_id!=pb.card_id AND
				ca.id=pa.card_id AND ca.visible AND NOT ca.deleted AND
				cb.id=pb.card_id AND cb.visible AND NOT cb.deleted AND
				(NOT pa.consider_stockcount OR (SELECT COALESCE(SUM(warehouse_items.stockcount),0) FROM warehouse_items,warehouses WHERE warehouses.applicable_to_eshop AND warehouse_items.warehouse_id=warehouses.id AND warehouse_items.product_id=pa.id)>0) AND
				(NOT pb.consider_stockcount OR (SELECT COALESCE(SUM(warehouse_items.stockcount),0) FROM warehouse_items,warehouses WHERE warehouses.applicable_to_eshop AND warehouse_items.warehouse_id=warehouses.id AND warehouse_items.product_id=pb.id)>0)
			GROUP BY pa.card_id, pb.card_id
			ORDER BY pa.card_id, score DESC, pb.card_id
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
