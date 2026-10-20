-- Precomputed "customers who bought this also bought" data.
-- Fully rebuilt by robots/frequently_bought_together_robot.php from real order history,
-- never edited by hand - see card_recommendation_boosts for the admin-curated counterpart.

CREATE SEQUENCE seq_also_bought_cards;
CREATE TABLE also_bought_cards (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_also_bought_cards'),
	card_id INTEGER NOT NULL,
	related_card_id INTEGER NOT NULL,
	score INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	CONSTRAINT fk_alsoboughtcards_cards FOREIGN KEY (card_id) REFERENCES cards ON DELETE CASCADE,
	CONSTRAINT fk_alsoboughtcards_related_cards FOREIGN KEY (related_card_id) REFERENCES cards ON DELETE CASCADE
);
CREATE INDEX in_alsoboughtcards_cardid ON also_bought_cards(card_id, rank);
CREATE INDEX in_alsoboughtcards_relatedcardid ON also_bought_cards(related_card_id);

-- needed by the robot's order_items self-join aggregation query
CREATE INDEX in_orderitems_productid ON order_items(product_id);
