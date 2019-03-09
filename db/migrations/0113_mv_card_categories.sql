CREATE MATERIALIZED VIEW mv_card_categories (card_id, category_id, parent_category_id, distance) AS (SELECT * FROM v_card_categories);

CREATE INDEX in_mvcardcategories_categoryid ON mv_card_categories(category_id, distance);
CREATE INDEX in_mvcardcategories_cardid ON mv_card_categories(card_id, distance);
