CREATE SEQUENCE seq_vat_rates START WITH 11;
CREATE TABLE vat_rates (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_vat_rates'),
	code VARCHAR(255),
	--
	vat_percent NUMERIC(5,2) NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_vatrates_code UNIQUE (code),
	CONSTRAINT fk_vatrates_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_vatrates_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
INSERT INTO vat_rates (id,code,vat_percent) VALUES(1,'default',21.0);
