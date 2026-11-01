-- Precomputed global "best selling" ranking, used by SellingAdvisor as the very last
-- resort fallback when there's no card/category/basket signal to go on at all (a
-- cold-start visitor browsing e.g. the basket page with nothing in it yet).
-- Fully rebuilt by robots/best_selling_cards_robot.php, never edited by hand.

CREATE SEQUENCE seq_best_selling_cards;
CREATE TABLE best_selling_cards (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_best_selling_cards'),
	card_id INTEGER NOT NULL,
	-- raw order counts per period, kept alongside the blended "score" so a sudden
	-- burst of recent sales (a new hit) can be told apart from stable year-round sales
	score_last_year INTEGER NOT NULL,
	score_last_month INTEGER NOT NULL,
	score_last_week INTEGER NOT NULL,
	score_last_day INTEGER NOT NULL,
	score DOUBLE PRECISION NOT NULL, -- blended score, used directly to order reads
	--
	CONSTRAINT unq_bestsellingcards_cardid UNIQUE (card_id),
	CONSTRAINT fk_bestsellingcards_cards FOREIGN KEY (card_id) REFERENCES cards ON DELETE CASCADE
);
