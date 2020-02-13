CREATE SEQUENCE seq_order_statuses START WITH 101;
CREATE TABLE order_statuses (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_statuses'),
	--
	code VARCHAR(255) NOT NULL,
	--
	notification_enabled BOOLEAN NOT NULL DEFAULT FALSE, -- toto nemeni uzivatel
	custom_notification_enabled BOOLEAN NOT NULL DEFAULT TRUE, -- toto si meni uzivatel
	bcc_email VARCHAR(1000),
	--
	blocking_stockcount BOOLEAN NOT NULL DEFAULT FALSE, -- blokuje objednavka v tomto stavu skladove mnozstvi? Viz view v_stockcount_blocations
	reduce_stockount BOOLEAN NOT NULL DEFAULT FALSE, -- po prechodu objednavky do takoveho stavu dojde ke snizeni skladoveho mnozstvi
	--
	finished_successfully BOOLEAN NOT NULL DEFAULT FALSE, -- uspesne ukonceni
	finished_unsuccessfully BOOLEAN NOT NULL DEFAULT FALSE, -- neuspesne ukonceni
	--
	finishing_successfully BOOLEAN NOT NULL DEFAULT FALSE, -- uspesne ukoncovani (zatim ne zcela jiste)
	finishing_unsuccessfully BOOLEAN NOT NULL DEFAULT FALSE, -- neuspesne ukoncovani (zatim ne zcela jiste)
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
	CONSTRAINT chk_orderstatuses_finish_flags CHECK((finished_successfully::INT + finished_unsuccessfully::INT + finishing_successfully::INT + finishing_unsuccessfully::INT) <= 1), -- pouze jeden z techto priznaku muze byt true
	CONSTRAINT fk_orderstatuses_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderstatuses_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_order_status_allowed_next_order_statuses;
CREATE TABLE order_status_allowed_next_order_statuses (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_status_allowed_next_order_statuses'),
	--
	order_status_id INT NOT NULL,
	allowed_next_order_status_id INT NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	CONSTRAINT fk_orderstatusallowednextorderstatuses_orderstatuses FOREIGN KEY (order_status_id) REFERENCES order_statuses(id) ON DELETE CASCADE,
	CONSTRAINT fk_orderstatusallowednextorderstatuses_allowednextorderstatuses FOREIGN KEY (allowed_next_order_status_id) REFERENCES order_statuses(id) ON DELETE CASCADE
);
