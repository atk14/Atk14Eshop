CREATE SEQUENCE seq_currencies START WITH 11;
CREATE TABLE currencies (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_currencies'),
	code CHAR(3) NOT NULL,
	decimals INT DEFAULT 2 NOT NULL,
	decimals_summary INT NOT NULL,
	lowest_price NUMERIC(20,6) DEFAULT 0.01 NOT NULL,
	lowest_order_price NUMERIC(20,6) DEFAULT 0.01 NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_currencies_code UNIQUE (code),
	CONSTRAINT fk_currencies_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_currencies_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO currencies VALUES (1,'CZK', 2, 0, 0.0100,1);
INSERT INTO currencies VALUES (2,'EUR', 2, 2, 0.0100,0.01);

CREATE SEQUENCE seq_currency_rates;
CREATE TABLE currency_rates(
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_currency_rates'),
	currency_id INT NOT NULL,
	rate_date TIMESTAMP NOT NULL DEFAULT NOW(), -- od tohoto datumu dany kurz plati
	rate FLOAT NOT NULL, -- kolik CZK (zakladni meny) je za jeden kus teto meny
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_currencyrates_currencie FOREIGN KEY (currency_id) REFERENCES currencies ON DELETE CASCADE,
	CONSTRAINT unq_currencyrates UNIQUE (currency_id,rate_date),
	CONSTRAINT fk_currencyrates_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_currencyrates_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO currency_rates (currency_id,rate_date,rate) VALUES(1,'1900-01-01',1.0);
INSERT INTO currency_rates (currency_id,rate_date,rate) VALUES(2,'2019-03-06',25.0);
