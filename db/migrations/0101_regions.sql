CREATE SEQUENCE seq_regisons;
CREATE TABLE regions (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_regisons'),
	code VARCHAR(255) NOT NULL,
	--
	name VARCHAR(255),
	email VARCHAR(255),
	domains JSON,
	languages JSON, -- ['cs','sk']
	currencies JSON, -- ['CZK','EUR']
	delivery_countries JSON, -- ['CZ','SK']
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_regions_code UNIQUE (code),
	CONSTRAINT fk_regison_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_regison_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO regions (code,name,domains,languages,currencies,delivery_countries) VALUES ('CR','Czech Republic','[]','["cs","en"]','["CZK"]','["CZ"]');
