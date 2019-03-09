-- Pomoci tohoto VIEW lze zjistit, v jakych vsech kategoriich se produkt (card_id) nachazi.
-- Neuvazuji se aliasy.
-- Zaznamy s distance=0 obsahuji ty kategorie, ve kterych je produkt rovnou vlozen.

CREATE OR REPLACE RECURSIVE VIEW v_card_categories (card_id,category_id,parent_category_id,distance) AS (
	SELECT
		category_cards.card_id,
		category_cards.category_id,
		categories.parent_category_id,
		0
	FROM
		category_cards,
		categories
	WHERE
		categories.id=category_cards.category_id
	UNION
		SELECT
			pr.card_id,
			c.id AS category_id,
			c.parent_category_id,
			pr.distance + 1
		FROM
			v_card_categories pr, categories c
		WHERE
			c.id=pr.parent_category_id
);
