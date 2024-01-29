ALTER TABLE vouchers ADD originator_order_item_id INT;
ALTER TABLE vouchers ADD CONSTRAINT fk_vouchers_originatororderitems FOREIGN KEY (originator_order_item_id) REFERENCES order_items;
CREATE INDEX in_vouchers_originatororderitemid ON vouchers (originator_order_item_id);
