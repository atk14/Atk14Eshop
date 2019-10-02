CREATE SEQUENCE seq_order_statuses START WITH 101;
CREATE TABLE order_statuses (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_statuses'),
	code VARCHAR(255),
	notification_enabled BOOLEAN NOT NULL DEFAULT FALSE,
	blocking_stockcount BOOLEAN NOT NULL DEFAULT FALSE, -- blokuje objednavka v tomto stavu skladove mnozstvi? Viz view v_stockcount_blocations
	reduce_stockount BOOLEAN NOT NULL DEFAULT FALSE, -- po prechodu objednavky do takoveho stavu dojde ke snizeni skladoveho mnozstvi
	--
	rank INT NOT NULL DEFAULT 999,
	--
	CONSTRAINT unq_orderstatuses_code UNIQUE (code)
);
