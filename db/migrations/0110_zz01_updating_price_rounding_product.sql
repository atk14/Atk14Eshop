UPDATE products SET vat_rate_id=(SELECT id FROM vat_rates WHERE code='default') WHERE code='price_rounding' AND vat_rate_id IS NULL;
