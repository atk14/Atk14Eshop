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
		orders.order_status_id IN (
		-- Tady musi byt vycet vsech pending stavu
		-- Oprava: jsou tady i uspesne dokoncene stavy
		1, -- new
		2, -- waiting_for_processing
		3, -- waiting_for_bank_transfer
		4, -- waiting_for_online_payment
		5, -- payment_accepted
		--  6, -- payment_failed
		7, -- processing
		8, -- on_the_way
		9, -- waiting_for_transport
		10, -- ready
		11, -- shipped
		12, -- delivered
		-- 13, -- cancelled
		14, -- waiting_for_check
		15, -- waiting_for_bank_transfer_info
		16, -- waiting_for_paypal_payment
		17, -- processed
		18 -- not_in_stock
		-- 19, -- returned_money
		) AND
		orders.created_at>NOW() - INTERVAL '24 hours' AND -- tady bylo puvodne '2 months'
		order_items.order_id=orders.id AND
		products.id=order_items.product_id AND
		products.consider_stockcount
);
