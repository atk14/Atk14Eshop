CREATE OR REPLACE VIEW v_stockcount_blocations (id,order_item_id,product_id,order_id,stockcount) AS (
	SELECT
		order_items.id AS id,
		order_items.id AS order_item_id,
		order_items.product_id,
		order_items.order_id,
		order_items.amount AS stockcount
	FROM
		orders,
		order_items,
		products
	WHERE
		orders.order_status_id IN (SELECT id FROM order_statuses WHERE blocking_stockcount) AND
		-- orders.created_at>NOW() - INTERVAL '24 hours' AND -- tady bylo puvodne '2 months'
		order_items.order_id=orders.id AND
		products.id=order_items.product_id
		-- AND products.consider_stockcount
);
