CREATE SEQUENCE seq_user_special_pricelists;
CREATE TABLE user_special_pricelists (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_user_special_pricelists'),
	--
	user_id INTEGER NOT NULL,
	pricelist_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	CONSTRAINT in_userspecialpricelists_users FOREIGN KEY (user_id) REFERENCES users ON DELETE CASCADE,
	CONSTRAINT in_userspecialpricelists_pricelists FOREIGN KEY (pricelist_id) REFERENCES pricelists
);

CREATE INDEX in_userspecialpricelists_userid ON user_special_pricelists(user_id);
