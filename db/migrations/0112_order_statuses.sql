CREATE SEQUENCE seq_order_statuses START WITH 101;
CREATE TABLE order_statuses (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_statuses'),
	--
	code VARCHAR(255) NOT NULL,
	--
	notification_enabled BOOLEAN NOT NULL DEFAULT FALSE,
	bcc_email VARCHAR(1000),
	--
	blocking_stockcount BOOLEAN NOT NULL DEFAULT FALSE, -- blokuje objednavka v tomto stavu skladove mnozstvi? Viz view v_stockcount_blocations
	reduce_stockount BOOLEAN NOT NULL DEFAULT FALSE, -- po prechodu objednavky do takoveho stavu dojde ke snizeni skladoveho mnozstvi
	--
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_orderstatuses_code UNIQUE (code),
	CONSTRAINT fk_orderstatuses_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderstatuses_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
