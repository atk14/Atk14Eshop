CREATE OR REPLACE FUNCTION user_basic_prices(user_id integer, date = CURRENT_TIMESTAMP) RETURNS setof pricelist_items STABLE LANGUAGE SQL AS $$
	SELECT
	 id,
	 pricelist_id,
	 product_id,
	 minimum_quantity,
	 price,
	 valid_from,
	 valid_to,
	 created_by_user_id,
	 updated_by_user_id,
	 created_at,
	 updated_at
	FROM (
	SELECT
		pricelist_items.*, row_number() over (partition by product_id order by minimum_quantity) as rn
	FROM pricelist_items WHERE
		pricelist_id = (SELECT pricelist_id FROM users WHERE id = $1) AND
        (valid_from is NULL or valid_from >= $2) AND
        (valid_to is NULL or valid_to <= $2)
	) q where
		rn = 1
$$;

CREATE OR REPLACE FUNCTION visible_products(user_id integer, date = CURRENT_TIMESTAMP) RETURNS setof products
STABLE LANGUAGE SQL AS $$
	SELECT * FROM products WHERE
		visible AND NOT deleted AND id IN (
			SELECT product_id FROM pricelist_items WHERE
				pricelist_id = (SELECT pricelist_id FROM users WHERE id = $1) AND
				(valid_from is NULL or valid_from >= $2) AND
				(valid_to is NULL or valid_to <= $2)
			)
$$;

CREATE OR REPLACE FUNCTION visible_cards(user_id integer, date = CURRENT_TIMESTAMP) RETURNS setof cards
STABLE LANGUAGE SQL AS $$
	SELECT * FROM cards WHERE
		visible AND NOT deleted AND id IN (SELECT id FROM visible_products($1, $2));
$$;
