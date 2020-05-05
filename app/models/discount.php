<?php
class Discount extends ApplicationModel {
	static $ProductsDiscounts;

	static function GetDiscountDataForProduct($product, $options=[]) {
		return self::$ProductsDiscounts->get($product, $options);
	}

	static function ReadDiscountForProducts($ids, $options) {
		$sql = "
			WITH RECURSIVE branches(product_id, category_id) AS (
				SELECT products.id, cc.category_id FROM products JOIN
					category_cards cc ON (cc.card_id = products.card_id)
					WHERE products.id IN :pid
				UNION (
					WITH childs AS (SELECT * FROM branches)
					SELECT childs.product_id, parent_category_id FROM categories JOIN childs ON (categories.id = childs.category_id)
					UNION
					SELECT childs.product_id, pointing_to_category_id FROM categories JOIN childs ON (categories.id = childs.category_id)
				)
			)
			SELECT product_id, discount_percent, discounted_from, discounted_to FROM (
				SELECT product_id, discount_percent, COALESCE(valid_from, created_at) as discounted_from, valid_to as discounted_to,
							 row_number() OVER (partition by product_id order by discount_percent DESC) as rn
				FROM (
					SELECT product_id, discount_percent, valid_from, valid_to, created_at FROM discounts WHERE
						product_id in :pid AND
						(valid_from IS NULL OR valid_from<=:now) AND
						(valid_to IS NULL OR valid_to>=:now)
					UNION
					SELECT branches.product_id, discount_percent, valid_from, valid_to, created_at FROM discounts
					JOIN branches ON (branches.category_id = discounts.category_id)
					WHERE
						(valid_from IS NULL OR valid_from<=:now) AND
						(valid_to IS NULL OR valid_to>=:now)
				 ) q ) q
			WHERE rn=1
		";
		$bind = [
			":pid" => $ids,
			":now" => now(),
		];
		$out = self::GetDbMole()->selectRows($sql, $bind);
		$out = array_column($out, null, 'product_id');
		return $out;
	}
}

Discount::$ProductsDiscounts = new CacheSomething(['Discount', 'ReadDiscountForProducts'], 'Product');
