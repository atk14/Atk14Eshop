ALTER TABLE order_statuses ADD next_automatic_order_status_id INT;
ALTER TABLE order_statuses ADD next_automatic_order_status_after_days INT;

ALTER TABLE order_statuses ADD CONSTRAINT fk_orderstatuses_nextautoorderstatuses FOREIGN KEY (next_automatic_order_status_id) REFERENCES order_statuses;
ALTER TABLE order_statuses ADD CONSTRAINT chk_orderstatuses_nextautoorderstatuses CHECK ((next_automatic_order_status_id IS NULL AND next_automatic_order_status_after_days IS NULL) OR (next_automatic_order_status_id IS NOT NULL AND next_automatic_order_status_after_days IS NOT NULL));
