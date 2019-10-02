<?php
class Discount extends ApplicationModel {
	static $ProductsDiscounts;

	static function GetDiscountForProduct($product, $options=[]) {
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
			SELECT product_id, MAX(discount_percent) FROM (
				SELECT product_id, discount_percent FROM discounts WHERE
					product_id in :pid AND
					(valid_from IS NULL OR valid_from<=:now) AND
					(valid_to IS NULL OR valid_to>=:now)
				UNION
				SELECT branches.product_id, discount_percent FROM discounts
				JOIN branches ON (branches.category_id = discounts.category_id)
				WHERE
					(valid_from IS NULL OR valid_from<=:now) AND
					(valid_to IS NULL OR valid_to>=:now)
			) q
			GROUP BY product_id
		";
		$bind = [
			":pid" => $ids,
			":now" => now(),
		];
		$out = self::GetDbMole()->selectIntoAssociativeArray($sql, $bind);
		return $out;
	}
}

Discount::$ProductsDiscounts = new CacheSomething(['Discount', 'ReadDiscountForProducts'], 'Product');
