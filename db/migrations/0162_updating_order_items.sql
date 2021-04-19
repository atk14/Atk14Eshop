-- see 0110_zz01_updating_price_rounding_product.sql
UPDATE order_items SET vat_percent=(SELECT vat_percent FROM vat_rates WHERE code='default') WHERE product_id=(SELECT id FROM products WHERE code='price_rounding') AND vat_percent IS NULL;
