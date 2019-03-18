-- Historie stavu objednavek.
-- Neni tady akt. stav, ten je v tabulce orders.
CREATE SEQUENCE seq_order_history;
CREATE TABLE order_history (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_history'),
	--
	order_id INTEGER NOT NULL,
	order_status_id INTEGER NOT NULL,
	responsible_user_id INT,
	--
	order_status_set_at TIMESTAMP NOT NULL,
	order_status_set_by_user_id INTEGER,
	note TEXT,
	--
	--
	change_status BOOLEAN NOT NULL,
	change_responsible_user BOOLEAN NOT NULL,
	--
	created_at TIMESTAMP DEFAULT NOW() NOT NULL,
	--
	CONSTRAINT fk_orderhistory_orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
	CONSTRAINT fk_orderhistory_orderstatuses FOREIGN KEY (order_status_id) REFERENCES order_statuses(id),
	CONSTRAINT fk_orderhistory_responsible_users FOREIGN KEY (responsible_user_id) REFERENCES users(id),
	CONSTRAINT fk_orderhistory_users FOREIGN KEY (order_status_set_by_user_id) REFERENCES users(id)
);

CREATE INDEX in_orderhistory_orderid ON order_history(order_id, order_status_set_at);
