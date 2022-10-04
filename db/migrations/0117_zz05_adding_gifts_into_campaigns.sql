ALTER TABLE campaigns ADD gift_product_id INT;
ALTER TABLE campaigns ADD gift_amount INT;
ALTER TABLE campaigns ADD gift_multiply BOOLEAN;

ALTER TABLE campaigns DROP CONSTRAINT chk_campaigns;
ALTER TABLE campaigns ADD CONSTRAINT chk_campaigns CHECK (
		(discount_percent=0.0 AND free_shipping=TRUE AND gift_product_id IS NULL AND gift_amount IS NULL AND gift_multiply IS NULL) OR
		(discount_percent>0.0 AND free_shipping=FALSE AND gift_product_id IS NULL AND gift_amount IS NULL AND gift_multiply IS NULL) OR
		(discount_percent=0.0 AND free_shipping=FALSE AND gift_product_id IS NOT NULL AND gift_amount IS NOT NULL AND gift_multiply IS NOT NULL)
);

ALTER TABLE order_campaigns ADD gift_order_item_id INT;
ALTER TABLE order_campaigns ADD CONSTRAINT fk_ordercampaigns_gift_orderitems FOREIGN KEY (gift_order_item_id) REFERENCES order_items ON DELETE CASCADE;
