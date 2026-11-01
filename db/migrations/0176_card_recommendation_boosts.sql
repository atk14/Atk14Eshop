-- Admin-managed, global list of products that should be preferred (or, with
-- "negative" set, actively suppressed) whenever they turn up as a candidate in the
-- "customers who bought this also bought" mechanism (see SellingAdvisor). It only
-- adjusts the score of a card that is already a candidate from another source - it
-- never forces an unrelated card in, nor hard-excludes one.

CREATE SEQUENCE seq_card_recommendation_boosts;
CREATE TABLE card_recommendation_boosts (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_card_recommendation_boosts'),
	card_id INTEGER NOT NULL,
	negative BOOLEAN NOT NULL DEFAULT FALSE,
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	created_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	--
	CONSTRAINT unq_cardrecommendationboosts_cardid UNIQUE (card_id),
	CONSTRAINT fk_cardrecommendationboosts_cards FOREIGN KEY (card_id) REFERENCES cards ON DELETE CASCADE,
	CONSTRAINT fk_cardrecommendationboosts_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users
);
CREATE INDEX in_cardrecommendationboosts_rank ON card_recommendation_boosts(rank);
